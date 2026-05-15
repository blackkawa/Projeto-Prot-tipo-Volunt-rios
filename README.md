# Voluntarie - Sistema de Gestão de Voluntários (HUM / UEM)

## 📌 Sobre o Projeto
O **Voluntarie** é um sistema web desenvolvido para a Divisão de Recursos Humanos do **Hospital Universitário Regional de Maringá (HUM)**. O objetivo principal do sistema é automatizar e gerenciar de ponta a ponta o programa de voluntariado do hospital, substituindo processos manuais por um fluxo digital eficiente. 

O sistema divide-se em duas grandes frentes de experiência (perfis de usuário):
1. **Portal do Voluntário:** Onde candidatos se inscrevem, enviam documentações obrigatórias, acompanham suas escalas de horários, visualizam avisos e solicitam declarações de horas consolidadas.
2. **Painel Administrativo (RH):** Destinado aos gestores do HUM para triagem de candidatos, validação de documentos, gerenciamento de vagas por departamento/setor, controle de escalas e emissão de relatórios consolidados com assinatura automatizada.

---

## 🎓 Contexto Acadêmico
Este projeto está sendo desenvolvido como parte das atividades práticas da disciplina de graduação:
* **Instituição:** Universidade Estadual de Maringá (UEM)
* **Departamento:** Departamento de Informática (DIN)
* **Curso:** Engenharia de Software
* **Disciplina:** 11928/31 - Laboratório de Engenharia de Software
* **Professor Orientador:** Prof. Dacio Fernando Machado Francisco
* **Data/Versão:** Abril - Junho de 2026 (Versão 1.0)

---

## 👥 Equipe de Desenvolvimento

| RA | Nome do Integrante |
| :--- | :--- |
| **133301** | Bruno Henrique de Pinho |

---

## 🚀 Principais Funcionalidades Mapeadas

### 🟢 Fluxo do Voluntário / Candidato
* **Seleção de Perfil e Autenticação:** Tela inicial intuitiva para segmentar o tipo de acesso. O fluxo do voluntário adota a identidade visual **Verde**.
* **Cadastro por Etapas (Wizard):** Coleta estruturada de Dados Pessoais, Formação Acadêmica/Profissional, Upload de Documentos Obrigatórios (RG/CPF, Comprovante de Residência e Certificados) e definição da Senha.
* **Visão Geral (Dashboard):** Exibição de avisos da administração, totalizador de horas voluntárias computadas e status de solicitações em tempo real.
* **Gestão de Horários:** Visualização de grade de escalas aprovadas e turnos disponíveis no hospital.

### 🔵 Fluxo do Administrador (RH / Gestão HUM)
* **Autenticação Segura:** Portal administrativo com identidade visual **Azul** exclusiva para servidores autorizados.
* **Triagem e Validação Documental:** Interface integrada para aprovar ou reprovar documentos anexados pelos candidatos com envio de feedback automático por e-mail.
* **Gestão de Vagas e Alocação:** Criação e distribuição de oportunidades de voluntariado segmentadas por setor ou departamento do hospital.
* **Relatórios e Assinatura Automática:** Filtro avançado (Ano × Departamento × Voluntário) para emissão de certidões e integração com o sistema **gov.br / eProtocolo** para assinaturas digitais automáticas.

---

## 🛠️ Requisitos e Arquitetura Tecnológica

### 🎯 Ambiente Alvo (Produção)
Conforme as restrições e o ambiente de TI do ambiente hospitalar da UEM, a versão homologada do sistema utilizará:
* **Linguagem:** Java (JDK versões 6 a 11)
* **Framework Web:** ZK Framework (para construção de componentes ricos de interface)
* **Banco de Dados:** IBM DB2
* **Integração Externa:** API gov.br / eProtocolo (único ponto de acoplamento externo)

### 🧪 Estado Atual do Repositório (Protótipo Visual)
Para fins de validação rápida de fluxo e experiência do usuário (UX), este repositório contém inicialmente um **Protótipo de Baixa/Média Fidelidade Estrutural** construído em:
* **HTML5** (Semântico)
* **CSS3** (Variáveis nativas e estilização dinâmica de perfis)
* **JavaScript Vanilla** (Lógica de navegação baseada em estado / *Single Page Application* simples)

---

## 💻 Como Executar o Protótipo Visual

Como o protótipo atual foi projetado para demonstração estática e validação imediata de telas com os clientes, ele não requer servidores ou dependências pesadas.

1. Faça o clone deste repositório ou baixe os arquivos:
   ```bash
   git clone [https://github.com/seu-usuario/voluntarie-hum.git](https://github.com/seu-usuario/voluntarie-hum.git)
