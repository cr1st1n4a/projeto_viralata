document.getElementById('enviarOrdem').addEventListener('click', function () {
    // Captura os valores dos campos
    const nomeRequerente = document.getElementById('nomeRequerente').value;
    const contato = document.getElementById('contato').value;
    const localResgate = document.getElementById('localResgate').value;
    const cep = document.getElementById('cep').value;
    const rua = document.getElementById('rua').value;
    const bairro = document.getElementById('bairro').value;
    const numero = document.getElementById('numero').value;

    // Validação simples
    if (!nomeRequerente || !contato || !localResgate || !cep || !rua || !bairro || !numero) {
        alert('Preencha todos os campos obrigatórios');
        return;
    }

    // Cria o formulário em formato de dados para enviar ao backend
    const form = document.getElementById('ordemForm');
    form.submit();  // Envia o formulário de forma tradicional ao backend
});

// Preenchimento automático do endereço com base no CEP usando ViaCEP
document.getElementById('cep').addEventListener('blur', function () {
    const cep = this.value.replace(/\D/g, '');
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('rua').value = data.logradouro;
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('localResgate').value = data.localidade + ', ' + data.uf;
                } else {
                    alert('CEP não encontrado.');
                }
            })
            .catch(() => alert('Erro ao buscar o CEP.'));
    }
});