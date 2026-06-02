<?php
/**
 * VOLUNTARIE - Camada de Simulação IBM DB2 para Ambientes Restritos
 * Disciplina: Laboratório de Engenharia de Software - UEM
 */

// Se a extensão real ibm_db2 NÃO estiver carregada no PHP (seu caso atual),
// nós criamos um "Simulador" das funções do DB2 para o protótipo funcionar offline.
if (!function_exists('db2_connect')) {

    // 1. Simula a função de conexão
    function db2_connect($database, $username, $password) {
        // Retorna uma string que representa o link da conexão simulada
        return "CONEXAO_SIMULADA_DB2_HUM";
    }

    // 2. Simula a mensagem de erro
    function db2_conn_errormsg() {
        return "Erro simulado no banco de dados.";
    }

    // 3. Simula a preparação da Query SQL
    function db2_prepare($connection, $statement) {
        // Guarda a estrutura da query para sabermos onde buscar depois
        return [
            'sql' => $statement,
            'params' => []
        ];
    }

    // 4. Simula a execução da Query guardando os parâmetros enviados (ex: e-mail)
    function db2_execute($stmt, $parameters) {
        global $parametros_da_query_atual;
        // Armazena temporariamente o e-mail digitado na tela de login
        $parametros_da_query_atual = $parameters;
        return true;
    }

    // 5. Simula o retorno dos dados do banco (Onde a mágica acontece)
    function db2_fetch_assoc($stmt) {
        global $parametros_da_query_atual;
        
        // Captura o e-mail que o usuário digitou no formulário
        $email_digitado = isset($parametros_da_query_atual[0]) ? $parametros_da_query_atual[0] : '';

        // MASSA DE DADOS DE TESTE (Simulando as tabelas do HUM)
        // Nota: O DB2 real retorna os índices em MAIÚSCULO por padrão, por isso as chaves em maiúsculo.
        $tabela_voluntarios = [
            'bruno@uem.br' => [
                'ID' => 133301, 
                'NOME' => 'Bruno Henrique de Pinho', 
                'SENHA' => '123456'
            ],
            'sophia@uem.br' => [
                'ID' => 133141, 
                'NOME' => 'Sophia Freire Aparicio', 
                'SENHA' => '123456'
            ],
            'mateus@uem.br' => [
                'ID' => 127486, 
                'NOME' => 'Mateus de Oliveira dos Reis', 
                'SENHA' => '123456'
            ]
        ];

        $tabela_administradores = [
            'admin@hum.uem.br' => [
                'ID' => 1, 
                'NOME' => 'Coordenador de RH (HUM)', 
                'SENHA' => 'adminhum'
            ]
        ];

        // Identifica qual tabela o código do login está tentando consultar
        $sql_minusculo = strtolower($stmt['sql']);

        if (strpos($sql_minusculo, 'from voluntario') !== false) {
            // Se achar o e-mail na lista de voluntários, retorna a linha, senão retorna falso
            return isset($tabela_voluntarios[$email_digitado]) ? $tabela_voluntarios[$email_digitado] : false;
        } 
        
        if (strpos($sql_minusculo, 'from administrador') !== false) {
            // Se achar o e-mail na lista de admins, retorna a linha, senão retorna falso
            return isset($tabela_administradores[$email_digitado]) ? $tabela_administradores[$email_digitado] : false;
        }

        return false;
    }

} else {
    // SE UM DIA O COLEGA EXECUTAR NUM PC COM DB2 INSTALADO:
    // O PHP vai ignorar o simulador acima e usar o banco real automaticamente.
    $database = "HUMDB"; 
    $user     = "db2admin";
    $password = "sua_senha_db2";
    
    $conn = db2_connect($database, $user, $password);
    if (!$conn) {
        die("Falha na conexão com o banco DB2 Real: " . db2_conn_errormsg());
    }
}
?>