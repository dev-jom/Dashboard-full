import os
import glob
import json
from bs4 import BeautifulSoup
from datetime import datetime, date, timedelta
import math

INPUT_DIR = '/home/jom0_0/projects/Dashboard-full/python/pages'  # Diretório onde estão os arquivos pagina_*.html
OUTPUT_FILE = 'tickets.json'

# Sprint inference reference (ajuste se necessário)
REF_SPRINT = 154
REF_START_DATE = '2025-12-04'  # formato YYYY-MM-DD
SPRINT_WORKDAYS = 10


def parse_created(s):
    if not s:
        return None
    s = str(s).replace(' h', '').strip()
    for fmt in ('%d/%m/%Y %H:%M', '%d/%m/%Y %H:%M:%S', '%Y-%m-%dT%H:%M:%S', '%d/%m/%Y'):
        try:
            return datetime.strptime(s, fmt)
        except Exception:
            continue
    # fallback: tenta extrair apenas a parte da data
    try:
        date_part = str(s).split()[0]
        return datetime.strptime(date_part, '%d/%m/%Y')
    except Exception:
        return None


def is_business_day(d: date):
    return d.weekday() < 5


def add_business_days(start_date: date, business_days: int):
    if business_days == 0:
        return start_date
    current = start_date
    step = 1 if business_days > 0 else -1
    remaining = abs(business_days)
    while remaining > 0:
        current = current + timedelta(days=step)
        if is_business_day(current):
            remaining -= 1
    return current


def business_days_between(start_date: date, end_date: date):
    if start_date == end_date:
        return 0
    sign = 1
    a = start_date
    b = end_date
    if start_date > end_date:
        sign = -1
        a, b = end_date, start_date
    days = 0
    cur = a
    while cur < b:
        cur = cur + timedelta(days=1)
        if is_business_day(cur):
            days += 1
    return days * sign


def infer_sprint_from_date(created_date: date, ref_sprint=REF_SPRINT, ref_start_date_str=REF_START_DATE, sprint_workdays=SPRINT_WORKDAYS):
    try:
        if '/' in ref_start_date_str:
            ref_start = datetime.strptime(ref_start_date_str, '%d/%m/%Y').date()
        else:
            ref_start = datetime.strptime(ref_start_date_str, '%Y-%m-%d').date()
    except Exception:
        ref_start = datetime(2025, 12, 4).date()

    bd_diff = business_days_between(ref_start, created_date)
    sprint_index = math.floor(bd_diff / sprint_workdays)
    sprint_number = ref_sprint + sprint_index
    sprint_start = add_business_days(ref_start, sprint_index * sprint_workdays)
    sprint_end = add_business_days(sprint_start, sprint_workdays - 1)
    return f"SP{sprint_number} ({sprint_start.strftime('%d/%m/%Y')} - {sprint_end.strftime('%d/%m/%Y')})"


def parse_html_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        html = f.read()
    soup = BeautifulSoup(html, 'html.parser')
    # Procura por qualquer tabela que tenha as classes 'list' e 'issues'
    table = None
    for t in soup.find_all('table'):
        classes = t.get('class', [])
        if 'list' in classes and 'issues' in classes:
            table = t
            break
    if not table:
        print(f"Tabela não encontrada em {filepath}!")
        return []
    # Cabeçalhos
    headers = []
    thead = table.find('thead')
    if thead:
        for th in thead.find_all('th'):
            header = th.get_text(strip=True)
            headers.append(header if header else 'col')
    # Busca todas as linhas que contenham 'issue' em qualquer parte da classe
    rows = []
    for tr in table.find_all('tr'):
        tr_classes = tr.get('class', [])
        if any('issue' in c for c in tr_classes):
            rows.append(tr)
    tickets = []
    for row in rows:
        cols = row.find_all('td')
        if not cols:
            continue
        ticket = {}
        id_value = None
        for idx, col in enumerate(cols):
            value = col.get_text(strip=True)
            key = headers[idx] if idx < len(headers) else f'col_{idx}'
            # Procura a coluna de id (pode ser '#' ou 'id')
            if key.strip().lower() in ['#', 'id', 'nº', 'número', 'numero']:
                value_clean = value.replace(',', '').replace(' ', '')
                ticket[key] = value_clean
                id_value = value_clean
            else:
                ticket[key] = value
        # Adiciona a coluna link
        if id_value and id_value.isdigit():
            ticket['link'] = f"https://redmine.pbsoft.com.br/issues/{id_value}"
        else:
            ticket['link'] = ''
        # Infer sprint from created date when Sprint column is missing or empty
        # possible created keys
        created_raw = ticket.get('Criado em') or ticket.get('created_at') or ticket.get('created_on')
        created_dt = parse_created(created_raw) if created_raw else None
        # detect sprint key (common header is 'Sprint')
        sprint_val = None
        for k in ticket.keys():
            if k.lower() == 'sprint':
                sprint_val = ticket.get(k)
                sprint_key = k
                break
        else:
            sprint_key = 'Sprint'

        if (not sprint_val or str(sprint_val).strip() == '') and created_dt:
            ticket[sprint_key] = infer_sprint_from_date(created_dt.date())
        tickets.append(ticket)
    return tickets


def main():
    all_tickets = []
    html_files = sorted(glob.glob(os.path.join(INPUT_DIR, 'pagina_*.html')))
    resumo = []
    for html_file in html_files:
        print(f"Processando {html_file}...")
        tickets = parse_html_file(html_file)
        print(f"Tickets encontrados: {len(tickets)}")
        if len(tickets) == 0:
            print(f"[AVISO] Nenhum ticket encontrado em {html_file}!")
        resumo.append((html_file, len(tickets)))
        all_tickets.extend(tickets)
    print("\nResumo por arquivo:")
    for fname, qtd in resumo:
        print(f"{fname}: {qtd} tickets")
    print(f"\nTotal de tickets coletados: {len(all_tickets)}")
    with open(OUTPUT_FILE, 'w', encoding='utf-8') as f:
        json.dump(all_tickets, f, ensure_ascii=False, indent=2)
    print(f"Dados salvos em {OUTPUT_FILE}")

if __name__ == "__main__":
    main()
