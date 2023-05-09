const locationFilter = document.getElementById('location');
const cards = document.querySelectorAll('.card');

locationFilter.addEventListener('change', function() {
    const selectedLocation = this.value;
    cards.forEach(card => {
        if (selectedLocation === 'all' || card.dataset.location === selectedLocation) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

