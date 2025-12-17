import json
# Caminho do JSON gerado
JSON_FILE = "/home/jhon/projects/dashboard-Full/python/tickets.json"

# Limite temporário de tickets a inserir (ajuste aqui)
LIMIT_TICKETS = 300  # Altere para o valor desejado



import os
import glob
from bs4 import BeautifulSoup
import psycopg2

# Configuração do banco (pegue do seu .env)
from datetime import datetime
DB_HOST = "186.227.205.42"
DB_PORT = 5432
DB_NAME = "devmaxima_dashboardjhon"
DB_USER = "devmaxima_jhon"
DB_PASS = "STC(,jPJObD(EOs*"

# Pasta dos HTMLs
HTML_DIR = "/home/jhon/projects/dashboard-Full/python/pages"

def extrair_tickets(html_file):
    with open(html_file, 'r', encoding='utf-8') as f:
        soup = BeautifulSoup(f, 'html.parser')
    # Tenta encontrar a tabela por múltiplas classes
    table = None
    for t in soup.find_all('table'):
        classes = t.get('class')
        if classes and 'list' in classes and 'issues' in classes:
            table = t
            break
    if not table:
        print('Tabela não encontrada! Listando todas as tabelas e suas classes:')
        for i, t in enumerate(soup.find_all('table')):
            print(f"Tabela {i}: classes = {t.get('class')}")
        return []
    print('Tabela encontrada!')
    tbody = table.find('tbody')
    if not tbody:
        print('tbody não encontrado!')
        return []
    print('tbody encontrado!')
    tr_list = tbody.find_all('tr')
    print(f"Encontrados {len(tr_list)} <tr> no tbody.")
    for i, tr in enumerate(tr_list):
        print(f"Linha {i}: classes = {tr.get('class')}")

    # Parser correto
    tickets = []
    for i, row in enumerate(tr_list):
        cols = row.find_all('td')
        if i == 0:
            print(f"Primeira linha tem {len(cols)} colunas.")
            for idx, col in enumerate(cols):
                print(f"Coluna {idx}: {col.get_text(strip=True)}")
        if len(cols) < 13:
            continue
        try:
            ticket_id = int(cols[1].get_text(strip=True)) if cols[1].get_text(strip=True) else None
            project = cols[2].get_text(strip=True)
            status = cols[3].get_text(strip=True)
            tamanho = cols[4].get_text(strip=True)
            escopo = cols[5].get_text(strip=True)
            subject = cols[6].get_text(strip=True)
            assigned_to = cols[7].get_text(strip=True)
            estimated_hours = cols[8].get_text(strip=True)
            spent_hours = cols[9].get_text(strip=True)
            tracker = cols[10].get_text(strip=True)
            sprint = cols[11].get_text(strip=True)
            if ticket_id is not None:
                tickets.append((ticket_id, project, status, tamanho, escopo, subject, assigned_to, estimated_hours, spent_hours, tracker, sprint))
        except Exception as e:
            print(f"Erro ao processar linha: {e}")
    return tickets

def inserir_tickets(tickets):
    print(f"Inserindo {len(tickets)} tickets no banco...")
    conn = psycopg2.connect(
        host=DB_HOST, port=DB_PORT, dbname=DB_NAME,
        user=DB_USER, password=DB_PASS
    )
    cur = conn.cursor()
    for t in tickets:
        cur.execute("""
            INSERT INTO tickets_redmine
            (id, project, status, tamanho, escopo, subject, assigned_to, estimated_hours, spent_hours, tracker, sprint, created_at, updated_at)
            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
            ON CONFLICT (id) DO NOTHING;
        """, t)
    conn.commit()
    cur.close()
    conn.close()

def main():
    # Lê o JSON
    with open(JSON_FILE, 'r', encoding='utf-8') as f:
        tickets_json = json.load(f)

    # Mapeia os campos do JSON para os campos do banco
    tickets = []
    def parse_created(s):
        if not s:
            return None
        # exemplo: "16/12/2025 11:50 h"
        s = s.replace(' h', '').strip()
        # tenta vários formatos
        for fmt in ('%d/%m/%Y %H:%M', '%d/%m/%Y %H:%M:%S', '%d/%m/%Y'):
            try:
                return datetime.strptime(s, fmt)
            except Exception:
                continue
        # fallback: tenta extrair parte da data
        try:
            parts = s.split()
            date_part = parts[0]
            return datetime.strptime(date_part, '%d/%m/%Y')
        except Exception:
            return None

    for t in tickets_json[:LIMIT_TICKETS]:
        # Ajuste os nomes dos campos conforme o seu JSON
        ticket_id = int(t.get('#') or t.get('id') or t.get('numero_ticket') or 0)
        project = t.get('Projeto', '')
        status = t.get('Situação', '')
        tamanho = t.get('Tamanho', '')
        escopo = t.get('Escopo', '')
        subject = t.get('Título', '')
        assigned_to = t.get('Atribuído para', '')
        estimated_hours = t.get('Tempo estimado', '')
        spent_hours = t.get('Tempo gasto', '')
        tracker = t.get('Tipo', '')
        sprint = t.get('Sprint', '')
        created_raw = t.get('Criado em') or t.get('created_at') or t.get('created_on')
        created_dt = parse_created(created_raw)
        if created_raw and not created_dt:
            print(f"Aviso: não foi possível parsear data de criação '{created_raw}' para ticket {ticket_id}")
        # updated_at: usar o mesmo valor do created_at (ou None)
        updated_dt = created_dt
        if ticket_id and ticket_id > 0:
            tickets.append((ticket_id, project, status, tamanho, escopo, subject, assigned_to, estimated_hours, spent_hours, tracker, sprint, created_dt, updated_dt))

    inserir_tickets(tickets)
    print(f"Total inserido: {len(tickets)}")

    # --- Para inserir todos os tickets do JSON, use este bloco (descomente para usar) ---
    # tickets = []
    # for t in tickets_json:
    #     ticket_id = int(t.get('#') or t.get('id') or t.get('numero_ticket') or 0)
    #     project = t.get('Projeto', '')
    #     status = t.get('Situação', '')
    #     tamanho = t.get('Tamanho', '')
    #     escopo = t.get('Escopo', '')
    #     subject = t.get('Título', '')
    #     assigned_to = t.get('Atribuído para', '')
    #     estimated_hours = t.get('Tempo estimado', '')
    #     spent_hours = t.get('Tempo gasto', '')
    #     tracker = t.get('Tipo', '')
    #     sprint = t.get('Sprint', '')
    #     tickets.append((ticket_id, project, status, tamanho, escopo, subject, assigned_to, estimated_hours, spent_hours, tracker, sprint))
    # inserir_tickets(tickets)
    # print(f"Total inserido: {len(tickets)} (todos)")

if __name__ == "__main__":
    main()