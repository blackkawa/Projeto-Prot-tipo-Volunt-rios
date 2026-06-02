# 🚀 Guia de Configuração do Ambiente: Java 11 + IBM DB2 no VS Code

Este guia orienta o passo a passo para configurar o banco de dados IBM DB2, preparar o projeto no **Visual Studio Code** e executar o servidor local de autenticação.

## 📋 Pré-requisitos

Antes de começar, garanta que você tem instalado:

1. **Java Development Kit (JDK) 11** ou superior.
2. **Visual Studio Code** com o **Extension Pack for Java** (da Microsoft) instalado.
3. **IBM DB2** rodando localmente (ou em um container).
4. O arquivo do driver JDBC do DB2 (**`db2jcc4.jar`**).

---

## 🗄️ Passo 1: Configuração do Banco de Dados (DB2)

Com os ajustes de credenciais feitos, o banco de dados deve ser criado com o nome `testedb` sob o usuário `teste`.

1. Certifique-se de que o seu script `configurar_db2.sh` está atualizado com as variáveis corretas:
```bash
NOME_BANCO="testedb"
USUARIO_DB2="teste"

```


2. Dê permissão de execução e execute o script com o usuário correspondente:
```bash
chmod +x configurar_db2.sh
sudo su - teste -c '/caminho/do/script/configurar_db2.sh'

```


> *Nota: Se a sua instância de DB2 ainda rodar centralizada no usuário padrão `db2inst1`, execute o script como `db2inst1`, mas certifique-se de que o usuário `teste` tem permissões de `CONNECT` e `DATAACCESS` no banco `testedb`.*



---

## 💻 Passo 2: Configurando o Projeto no VS Code

Para que o VS Code entenda o código Java e não exiba erros de compilação referentes ao Driver do DB2 (`DriverManager`), precisamos adicionar o `.jar` ao Classpath do projeto.

### 1. Abrir a Pasta no VS Code

Abra o VS Code, vá em **File > Open Folder...** (Arquivo > Abrir Pasta...) e selecione o diretório onde está o seu arquivo `ServidorLocalDB2.java`.

### 2. Adicionar o Driver JDBC (`db2jcc4.jar`)

Com a extensão *Extension Pack for Java* ativa, o VS Code criará uma aba dedicada a projetos Java na barra lateral:

1. No menu lateral esquerdo do VS Code, clique no ícone do **Java Projects** (geralmente fica na parte inferior da árvore de arquivos).
2. Localize a seção **Referenced Libraries** (Bibliotecas Referenciadas).
3. Clique no ícone de **+** (Plus) ao lado de *Referenced Libraries*.
4. Navegue no seu computador, selecione o arquivo **`db2jcc4.jar`** e clique em **Append Library**.

> 💡 *Isso fará com que o VS Code gerencie o classpath automaticamente, eliminando a necessidade de passar o parâmetro `-cp` manualmente via terminal.*

---

## ⚙️ Passo 3: Executando o Servidor pelo VS Code

Agora você não precisa do terminal externo para rodar a aplicação.

1. Abra o arquivo `ServidorLocalDB2.java` no editor.
2. Você notará que logo acima do método `public static void main`, o VS Code exibirá dois pequenos links flutuantes: **Run** | **Debug**.
3. Clique em **Run**.

O terminal integrado do VS Code se abrirá automaticamente exibindo a mensagem de sucesso:

```text
Servidor Java 11 iniciado localmente em http://127.0.0.1:8080

```

---

## 🧪 Passo 4: Testando os Endpoints

Com o servidor rodando pelo VS Code, você pode abrir um terminal limpo e testar a comunicação com as novas credenciais do banco usando o `curl`:

### Testar Login de Voluntário

```bash
curl -X POST http://127.0.0.1:8080/api/login/voluntario \
     -H "Content-Type: application/x-www-form-urlencoded" \
     -d "cpf=12345678901&senha=senhaVol"

```

### Testar Login de Gerente

```bash
curl -X POST http://127.0.0.1:8080/api/login/gerente \
     -H "Content-Type: application/x-www-form-urlencoded" \
     -d "cpf=98765432100&senha=senhaGer"

```

**Resposta JSON esperada (Status 200):**

```json
{"status":"sucesso","mensagem":"Login autorizado","id":1}

```