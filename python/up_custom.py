#!/usr/bin/env python3
"""
up_custom.py

Rápido uploader de JSON custom para a tabela `tickets_redmine`.

Uso:
  python up_custom.py --file json_custom.json [--limit 300]

Ele tenta mapear os campos mais comuns do seu `tickets.json` e insere
com `ON CONFLICT (id) DO NOTHING` para evitar duplicados.

Configuração do banco pode vir via variáveis de ambiente:
  DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS
ou usar os valores padrão embutidos (os mesmos do `data.py`).

Esse script é pensado para testes rápidos — se precisar de alta
performance para muitos milhares de linhas, podemos adaptar para
usar `COPY` ou `psycopg2.extras.execute_batch`.
"""

import argparse
import json
import os
from datetime import datetime
import psycopg2


def parse_args():
    p = argparse.ArgumentParser(description='Upload JSON custom para tickets_redmine')
    p.add_argument('--file', '-f', required=False, default='custom.json', help='Caminho para o JSON (array de objetos). Padrão: "custom.json"')
    p.add_argument('--limit', '-n', type=int, default=None, help='Limite de registros a inserir (para testes)')
    p.add_argument('--dry-run', action='store_true', help='Não grava no banco, apenas mostra resumo')
    return p.parse_args()


# DB defaults (copiados do data.py, altere se necessário)
DB_HOST = os.environ.get('DB_HOST', '186.227.205.42')
DB_PORT = int(os.environ.get('DB_PORT', 5432))
DB_NAME = os.environ.get('DB_NAME', 'devmaxima_dashboardjhon')
DB_USER = os.environ.get('DB_USER', 'devmaxima_jhon')
DB_PASS = os.environ.get('DB_PASS', 'STC(,jPJObD(EOs*')


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


def read_json(path):
    with open(path, 'r', encoding='utf-8') as f:
        return json.load(f)


def map_ticket(obj):
    # tenta mapear os campos mais comuns presentes no JSON gerado
    ticket_id = int(obj.get('#') or obj.get('id') or obj.get('numero_ticket') or 0)
    project = obj.get('Projeto') or obj.get('project') or ''
    status = obj.get('Situação') or obj.get('status') or ''
    tamanho = obj.get('Tamanho') or obj.get('size') or ''
    escopo = obj.get('Escopo') or obj.get('scope') or ''
    subject = obj.get('Título') or obj.get('subject') or ''
    assigned_to = obj.get('Atribuído para') or obj.get('assigned_to') or ''
    estimated_hours = obj.get('Tempo estimado') or obj.get('estimated_hours') or ''
    spent_hours = obj.get('Tempo gasto') or obj.get('spent_hours') or ''
    tracker = obj.get('Tipo') or obj.get('type') or ''
    sprint = obj.get('Sprint') or obj.get('sprint') or ''
    created_raw = obj.get('Criado em') or obj.get('created_at') or obj.get('created_on')
    created_dt = parse_created(created_raw)
    updated_dt = created_dt
    return (ticket_id, project, status, tamanho, escopo, subject, assigned_to, estimated_hours, spent_hours, tracker, sprint, created_dt, updated_dt)


def insert_tickets(conn, tuples):
    cur = conn.cursor()
    sql = '''
        INSERT INTO tickets_redmine
        (id, project, status, tamanho, escopo, subject, assigned_to, estimated_hours, spent_hours, tracker, sprint, created_at, updated_at)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        ON CONFLICT (id) DO NOTHING;
    '''
    # usar executemany para velocidade razoável
    cur.executemany(sql, tuples)
    conn.commit()
    cur.close()


def main():
    args = parse_args()
    # Resolve o caminho do arquivo: aceita caminhos relativos e tenta
    # primeiro no cwd, depois no diretório do script (python/)
    json_path = args.file
    if not os.path.isabs(json_path) and not os.path.exists(json_path):
        # tenta no mesmo diretório do script (onde up_custom.py está)
        script_dir = os.path.dirname(os.path.abspath(__file__))
        alt = os.path.join(script_dir, json_path)
        if os.path.exists(alt):
            json_path = alt
    if not os.path.exists(json_path):
        print(f"Arquivo JSON não encontrado: {args.file} (tente passar --file ou coloque '{args.file}' na pasta python/)")
        return
    data = read_json(json_path)
    if not isinstance(data, list):
        print('Erro: o JSON deve ser um array de objetos (lista).')
        return

    if args.limit:
        data = data[:args.limit]

    mapped = []
    warnings = 0
    for obj in data:
        try:
            tup = map_ticket(obj)
            if tup[0] <= 0:
                print(f"Ignorando ticket sem id válido: {obj}")
                continue
            if tup[11] is None:
                warnings += 1
            mapped.append(tup)
        except Exception as e:
            print(f"Erro mapeando objeto: {e}")

    print(f"Registros a inserir: {len(mapped)} (warning: {warnings} sem created_at parseado)")
    if args.dry_run:
        print('Dry run -- não será feita inserção no BD.')
        return

    conn = psycopg2.connect(host=DB_HOST, port=DB_PORT, dbname=DB_NAME, user=DB_USER, password=DB_PASS)
    try:
        insert_tickets(conn, mapped)
        print('Inserção concluída com sucesso.')
    finally:
        conn.close()


if __name__ == '__main__':
    main()
