const searchInput = document.getElementById('filmSearch');
const filmCards = document.querySelectorAll('.film-card');

const durationSelect = document.getElementById('film-filter');

durationSelect.addEventListener('change', function(){
    const searchDuration = this.value;

    filmCards.forEach(card => {
        const duration = card.dataset.duration;
        switch(searchDuration){
            case "small":
                if (Number(duration) < 90){
                    card.style.display = "";
                } else{
                    card.style.display = "none";
                }
                break;
            case "medium":
                if (Number(duration) >= 90 && Number(duration) <= 120){
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
                break;
            case "huge":
                if (Number(duration) > 120){
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
                break;
            case "":
                card.style.display = "";
                break;
        }
    })
})


searchInput.addEventListener('input', function () {

    const searchValue = this.value.toLowerCase();

    filmCards.forEach(card => {

        const title = card.dataset.title;

        if (title.includes(searchValue)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }

    });

});




// BUTTON FOR EDITINNGNGNGNGNGN

const editButtons = document.querySelectorAll('.film-edit-button');

editButtons.forEach(button => {
    button.addEventListener('click', function () {
        window.location.href = this.dataset.url;
    });
});



// BUTTON FOR DEELETINGGG


const deleteForms = document.querySelectorAll('.film-delete-form');

deleteForms.forEach(form => {
    form.addEventListener('submit', function(event) {

        const confirmed = confirm(
            'Weet je zeker dat je deze film wilt verwijderen?'
        );

        if (!confirmed) {
            event.preventDefault();
        }

    });
});
