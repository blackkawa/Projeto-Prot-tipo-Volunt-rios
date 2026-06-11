import com.sun.net.httpserver.HttpExchange;
import com.sun.net.httpserver.HttpHandler;
import com.sun.net.httpserver.HttpServer;

import java.io.IOException;
import java.io.OutputStream;
import java.net.InetSocketAddress;
import java.nio.charset.StandardCharsets;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.Arrays;
import java.util.Map;
import java.util.stream.Collectors;

public class ServidorLocalDB2 {

    // Configurações do Banco de Dados DB2
    private static final String DB_URL = "jdbc:db2://localhost:50000/testedb";
    private static final String DB_USER = "teste";
    private static final String DB_PASS = "123";

    public static void main(String[] args) throws Exception {

        // Cria o servidor HTTP escutando APENAS no localhost (127.0.0.1)
        var server = HttpServer.create(new InetSocketAddress("127.0.0.1", 8080), 0);
        
        // Define os endpoints usando expressões Lambda
        server.createContext("/api/login/voluntario", new LoginHandler("VOLUNTARIOS"));
        server.createContext("/api/login/gerente", new LoginHandler("GERENTES"));
        
        server.setExecutor(null); 
        System.out.println("Servidor Java 11 iniciado localmente em http://127.0.0.1:8080");
        server.start();
    }

    static class LoginHandler implements HttpHandler {
        private final String tabela;

        public LoginHandler(String tabela) {
            this.tabela = tabela;
        }

        @Override
        public void handle(HttpExchange exchange) throws IOException {
            // Validação do método HTTP
            if (!"POST".equals(exchange.getRequestMethod())) {
                enviarResposta(exchange, 405, "Método não permitido. Use POST.");
                return;
            }

            // Lendo o corpo do POST e convertendo para String usando UTF-8
            var body = new String(exchange.getRequestBody().readAllBytes(), StandardCharsets.UTF_8);
            
            Map<String, String> parametros = extrairParametros(body);
            var cpf = parametros.get("cpf");
            var senha = parametros.get("senha");

            if (cpf == null || senha == null) {
                enviarResposta(exchange, 400, "Dados incompletos. Envie 'cpf' e 'senha'.");
                return;
            }

            // Try-with-resources: Garante o fechamento automático de Conexão, Statement e ResultSet
            String sql = "SELECT ID FROM " + tabela + " WHERE CPF = ? AND SENHA = ?";
            
            try (Connection conn = DriverManager.getConnection(DB_URL, DB_USER, DB_PASS);
                 PreparedStatement stmt = conn.prepareStatement(sql)) {
                
                stmt.setString(1, cpf);
                stmt.setString(2, senha);

                try (ResultSet rs = stmt.executeQuery()) {
                    if (rs.next()) {
                        int id = rs.getInt("ID");                        var jsonResposta = String.format("{\"status\":\"sucesso\",\"mensagem\":\"Login autorizado\",\"id\":%d}", id);
                        enviarResposta(exchange, 200, jsonResposta);
                    } else {
                        enviarResposta(exchange, 401, "{\"status\":\"erro\",\"mensagem\":\"CPF ou senha incorretos\"}");
                    }
                }

            } catch (Exception e) {
                e.printStackTrace();
                enviarResposta(exchange, 500, "Erro interno no servidor: " + e.getMessage());
            }
        }

        // Conversão limpa da Query String para um Map usando a API de Streams
        private Map<String, String> extrairParametros(String body) {
            return Arrays.stream(body.split("&"))
                    .map(param -> param.split("="))
                    .filter(par -> par.length == 2)
                    .collect(Collectors.toMap(par -> par[0], par -> par[1], (antigo, novo) -> antigo));
        }

        private void enviarResposta(HttpExchange exchange, int statusCode, String resposta) throws IOException {
        exchange.getResponseHeaders().set("Access-Control-Allow-Origin", "*");
    
        exchange.getResponseHeaders().set("Content-Type", "application/json; charset=UTF-8");
        byte[] bytes = resposta.getBytes(StandardCharsets.UTF_8);
        exchange.sendResponseHeaders(statusCode, bytes.length);

        try (OutputStream os = exchange.getResponseBody()) {
            os.write(bytes);
        }

        }
    }
}