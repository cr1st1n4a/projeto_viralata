/meu_projeto/
  /app/
    /controllers/
      AnimalController.php         // Controlador para manipulação de dados de animais (CRUD)
      UsuarioController.php         // Controlador para gerenciamento de usuários e autenticação
      PedidoAdocaoController.php    // Controlador para gerenciar solicitações de adoção
      MedicamentoController.php      // Controlador para manipulação de dados de medicamentos (CRUD)
    /views/
      index.html                    // Página inicial que exibe a lista de animais
      criar.html                    // Formulário para cadastrar um novo animal
      adotar.html                    // Formulário para solicitar a adoção de um animal
      listar_remedios.html           // Página para exibir a lista de medicamentos disponíveis
      criar_remedio.html             // Formulário para adicionar um novo medicamento
      cabecalho.html                 // Arquivo comum para o cabeçalho de todas as páginas
      rodape.html                    // Arquivo comum para o rodapé de todas as páginas
  /html/
    index.php                      // Arquivo principal que gerencia o roteamento e inclui as views
    script.js                      // Arquivo opcional para scripts JavaScript