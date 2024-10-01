document.getElementById('cadastroAnimais').addEventListener('submit', async function(event) {
    event.preventDefault(); // Evitar o envio padrão do formulário

    const formData = new FormData(this);

    try {
        const response = await fetch('/animais/cadastro', {
            method: 'POST',
            body: formData,
        });

        const text = await response.text(); // Ler a resposta como texto
        console.log('Raw response:', text); // Log da resposta bruta

        if (!response.ok) {
            throw new Error(text); // Lançar erro com texto
        }

        let data;
        try {
            data = JSON.parse(text); // Tentar converter para JSON
        } catch (e) {
            throw new Error('Resposta não é JSON válido: ' + text);
        }

        console.log('Success:', data);
        alert(data.msg); // Mensagem de sucesso para o usuário
        window.location.href = '/animais/lista'; // Redirecionar para a lista
    } catch (error) {
        console.error('Error:', error);
        alert('Ocorreu um erro: ' + error.message); // Mensagem de erro para o usuário
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const especieFilter = document.getElementById('filter-especie');
    const statusFilter = document.getElementById('filter-status');
    const animalCards = document.querySelectorAll('.animal-card');

    if (searchInput) {
        searchInput.addEventListener('input', filterAnimals);
    }
    if (especieFilter) {
        especieFilter.addEventListener('change', filterAnimals);
    }
    if (statusFilter) {
        statusFilter.addEventListener('change', filterAnimals);
    }

    function filterAnimals() {
        const searchValue = searchInput ? searchInput.value.toLowerCase() : '';
        const especieValue = especieFilter ? especieFilter.value.toLowerCase() : '';
        const statusValue = statusFilter ? statusFilter.value.toLowerCase() : '';

        animalCards.forEach(card => {
            const nome = card.querySelector('.card-title').textContent.toLowerCase();
            const especie = card.getAttribute('data-especie').toLowerCase();
            const status = card.getAttribute('data-status').toLowerCase();

            const matchesSearch = nome.includes(searchValue);
            const matchesEspecie = especie.includes(especieValue);
            const matchesStatus = status.includes(statusValue);

            if (matchesSearch && (especieValue === '' || matchesEspecie) && (statusValue === '' || matchesStatus)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }
});

function deleteAnimal(button) {
    const id = button.getAttribute('data-id');
    if (confirm('Tem certeza que deseja excluir este animal?')) {
        fetch('/animais/delete/' + id, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    alert(data.msg);
                    location.reload(); // Recarrega a página para refletir a exclusão
                } else {
                    alert(data.msg);
                }
            })
            .catch(error => {
                alert('Restrição ao excluir o animal: ' + error);
            });
    }
}

function editAnimal(button) {
    const id = button.getAttribute('data-id');
    window.location.href = '/animais/alterar/' + id; // Redireciona para a página de edição
}
