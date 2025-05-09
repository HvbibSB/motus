document.addEventListener('DOMContentLoaded', function() {
    // Mise au point automatique du champ de saisie
    const guessInput = document.querySelector('input[name="guess"]');
    if (guessInput) {
        guessInput.focus();
        
        // Mise au point automatique, conversion des données en majuscules lorsque l'utilisateur tape dans le champ de saisie.
        guessInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    }
    
    // Empêcher la soumission d'un formulaire si la longueur des données saisies ne correspond pas à la longueur du formulaire
    const guessForm = document.querySelector('.guess-form');
    if (guessForm) {
        guessForm.addEventListener('submit', function(e) {
            const input = this.querySelector('input[name="guess"]');
            if (input && input.value.length !== parseInt(input.getAttribute('maxlength'))) {
                e.preventDefault();
                alert(`Veuillez entrer un mot de ${input.getAttribute('maxlength')} lettres.`);
            }
        });
    }
    
    // Validation du formulaire de score de sauvegarde
    const saveForm = document.querySelector('.save-score');
    if (saveForm) {
        saveForm.addEventListener('submit', function(e) {
            const nameInput = this.querySelector('input[name="player_name"]');
            if (nameInput && nameInput.value.trim() === '') {
                e.preventDefault();
                alert('Veuillez entrer votre nom pour enregistrer votre score.');
                nameInput.focus();
            }
        });
    }
});