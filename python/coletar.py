from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from bs4 import BeautifulSoup
import json
import time

# Configurações
BASE_URL = "https://redmine.pbsoft.com.br/issues?c%5B%5D=project&c%5B%5D=status&c%5B%5D=cf_3&c%5B%5D=cf_1&c%5B%5D=subject&c%5B%5D=assigned_to&c%5B%5D=estimated_hours&c%5B%5D=spent_hours&c%5B%5D=tracker&c%5B%5D=cf_19&f%5B%5D=status_id&f%5B%5D=created_on&f%5B%5D=&group_by=&op%5Bcreated_on%5D=%3E%3C&op%5Bstatus_id%5D=%2A&set_filter=1&sort=id%3Adesc&t%5B%5D=estimated_hours&t%5B%5D=spent_hours&t%5B%5D=&utf8=%E2%9C%93&v%5Bcreated_on%5D%5B%5D=2024-01-01&v%5Bcreated_on%5D%5B%5D=2025-12-31"
TOTAL_PAGES = 12  # Atualize se necessário
OUTPUT_FILE = "tickets.json"

LOGIN_URL = 'https://redmine.pbsoft.com.br/login'
USERNAME = 'jonathas'  # coloque seu usuário
PASSWORD = 'PClsZVnWRWOl'  # coloque sua senha
URL_FILTRADA = 'https://redmine.pbsoft.com.br/issues?c%5B%5D=project&c%5B%5D=status&c%5B%5D=cf_3&c%5B%5D=cf_1&c%5B%5D=subject&c%5B%5D=assigned_to&c%5B%5D=estimated_hours&c%5B%5D=spent_hours&c%5B%5D=tracker&c%5B%5D=cf_19&c%5B%5D=created_on&f%5B%5D=status_id&f%5B%5D=created_on&f%5B%5D=&group_by=&op%5Bcreated_on%5D=%3E%3C&op%5Bstatus_id%5D=%2A&per_page=500&set_filter=1&sort=id%3Adesc&t%5B%5D=estimated_hours&t%5B%5D=spent_hours&t%5B%5D=&utf8=%E2%9C%93&v%5Bcreated_on%5D%5B%5D=2024-01-01&v%5Bcreated_on%5D%5B%5D=2025-12-31'

chrome_options = Options()
chrome_options.add_argument('--start-maximized')
# chrome_options.add_argument('--headless')  # Se quiser rodar sem interface gráfica

def scrape_table(html):
    soup = BeautifulSoup(html, 'html.parser')
    table = soup.find('table', {'class': 'list issues'})
    if not table:
        print("Tabela não encontrada!")
        return []
    # Pega o cabeçalho para nomes dinâmicos das colunas
    headers = []
    thead = table.find('thead')
    if thead:
        for th in thead.find_all('th'):
            header = th.get_text(strip=True)
            # Normaliza o nome do header para facilitar busca
            headers.append(header if header else 'col')
    # print(f"Headers encontrados: {headers}")
    rows = table.find_all('tr', {'class': 'issue'})
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
        tickets.append(ticket)
    return tickets

def main():
    driver = webdriver.Chrome(options=chrome_options)
    print('Acessando a página de login do Redmine...')
    driver.get(LOGIN_URL)
    try:
        WebDriverWait(driver, 15).until(
            EC.presence_of_element_located((By.XPATH, '//*[@id="login-form"]'))
        )
        driver.find_element(By.XPATH, '//*[@id="username"]').send_keys(USERNAME)
        driver.find_element(By.XPATH, '//*[@id="password"]').send_keys(PASSWORD)
        driver.find_element(By.XPATH, '//*[@id="login-submit"]').click()
        print('Login realizado!')
    except Exception as e:
        print('Erro ao logar:', e)
        driver.quit()
        return
    print('Acessando a URL filtrada...')
    driver.get(URL_FILTRADA)
    time.sleep(3)
    all_tickets = []
    for page in range(1, TOTAL_PAGES + 1):
        url = f"{URL_FILTRADA}&page={page}"
        print(f"Coletando página {page}: {url}")
        driver.get(url)
        try:
            WebDriverWait(driver, 15).until(
                EC.presence_of_element_located((By.XPATH, '//table[contains(@class, "list") and contains(@class, "issues")]'))
            )
        except Exception as e:
            print(f"Tabela não encontrada na página {page}: {e}")
            html = driver.page_source
        else:
            html = driver.page_source
        # Salvar HTML da div autoscroll
        try:
            soup = BeautifulSoup(html, 'html.parser')
            autoscroll_div = soup.find('div', {'class': 'autoscroll'})
            if autoscroll_div:
                with open(f'pagina_{page}.html', 'w', encoding='utf-8') as f:
                    f.write(str(autoscroll_div))
                print(f"HTML da página {page} salvo em pagina_{page}.html")
            else:
                print(f"Div autoscroll não encontrada na página {page}")
        except Exception as e:
            print(f"Erro ao salvar HTML da página {page}: {e}")
        tickets = scrape_table(html)
        print(f"Tickets encontrados nesta página: {len(tickets)}")
        all_tickets.extend(tickets)
    driver.quit()
    print(f"Total de tickets coletados: {len(all_tickets)}")
    with open(OUTPUT_FILE, 'w', encoding='utf-8') as f:
        json.dump(all_tickets, f, ensure_ascii=False, indent=2)
    print(f"Dados salvos em {OUTPUT_FILE}")

if __name__ == "__main__":
    main()
