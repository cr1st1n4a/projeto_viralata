/meu_projeto/
  /app/
    /controllers_models/
      AnimalController.php         // Controlador para manipulação de dados de animais (CRUD)
      UsuarioController.php         // Controlador para gerenciamento de usuários e autenticação
      PedidoAdocaoController.php    // Controlador para gerenciar solicitações de adoção
      MedicamentoController.php      // Controlador para manipulação de dados de medicamentos (CRUD)
    /views/
      index.php                    // Página inicial que exibe a lista de animais
      criar.php                    // Formulário para cadastrar um novo animal
      adotar.php                    // Formulário para solicitar a adoção de um animal
      listar_remedios.php           // Página para exibir a lista de medicamentos disponíveis
      criar_remedio.php             // Formulário para adicionar um novo medicamento
      cabecalho.php                 // Arquivo comum para o cabeçalho de todas as páginas
      rodape.php                    // Arquivo comum para o rodapé de todas as páginas
  /html/
    index.php                      // Arquivo principal que gerencia o roteamento e inclui as views
    estilo.css                     // Arquivo opcional para estilos (CSS)
    script.js                      // Arquivo opcional para scripts JavaScript