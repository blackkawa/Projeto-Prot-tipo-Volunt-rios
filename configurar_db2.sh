#!/bin/bash

# ==============================================================================
# SCRIPT DE CONFIGURAÇÃO AUTOMÁTICA DO DB2 PARA O SERVIDOR JAVA
# ==============================================================================

# Configurações - Altere se necessário
NOME_BANCO="testedb"
USUARIO_DB2="teste"

echo "=== Iniciando a configuração inicial do DB2 ==="

# Força a execução como o usuário dono da instância do DB2 (geralmente db2inst1)
if [ "$(whoami)" != "$USUARIO_DB2" ]; then
    echo "Erro: Este script deve ser executado como o usuário '$USUARIO_DB2'."
    echo "Tente: sudo su - $USUARIO_DB2 -c '$(realpath $0)'"
    exit 1
fi

# 1. Inicializa o ambiente do DB2
if [ -f ~/sqllib/db2profile ]; then
    . ~/sqllib/db2profile
fi

echo "1. Criando o banco de dados '$NOME_BANCO' com suporte a UTF-8..."
# O DB2 exige UTF-8 (USING CODESET UTF-8 TERRITORY BR) para processar caracteres locais do Brasil
db2 CREATE DATABASE $NOME_BANCO USING CODESET UTF-8 TERRITORY BR

if [ $? -eq 0 ]; then
    echo "Banco de dados criado com sucesso!"
else
    echo "Aviso: O banco de dados pode já existir ou ocorreu um erro. Continuando..."
fi

echo "2. Conectando ao banco de dados..."
db2 CONNECT TO $NOME_BANCO

# 3. Criação das Tabelas
echo "3. Criando as tabelas VOLUNTARIOS e GERENTES..."

db2 -tf << EOF
-- Criação da tabela de Voluntários
CREATE TABLE VOLUNTARIOS (
    ID INT GENERATED ALWAYS AS IDENTITY (START WITH 1, INCREMENT BY 1) NOT NULL,
    CPF VARCHAR(11) NOT NULL UNIQUE,
    SENHA VARCHAR(255) NOT NULL,
    NOME VARCHAR(100),
    PRIMARY KEY (ID)
);

-- Criação da tabela de Gerentes
CREATE TABLE GERENTES (
    ID INT GENERATED ALWAYS AS IDENTITY (START WITH 1, INCREMENT BY 1) NOT NULL,
    CPF VARCHAR(11) NOT NULL UNIQUE,
    SENHA VARCHAR(255) NOT NULL,
    NOME VARCHAR(100),
    PRIMARY KEY (ID)
);

-- Inserção de dados de teste iniciais (Opcional)
INSERT INTO VOLUNTARIOS (CPF, SENHA, NOME) VALUES ('12345678901', 'senhaVol', 'Voluntário de Teste');
INSERT INTO GERENTES (CPF, SENHA, NOME) VALUES ('98765432100', 'senhaGer', 'Gerente de Teste');

EOF

echo "4. Desconectando do banco..."
db2 CONNECT RESET
db2 TERMINATE

echo "=== Configuração do DB2 concluída com sucesso! ==="