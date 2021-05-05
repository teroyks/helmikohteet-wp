/**
 * Helmikohteet shortcode listing filter
 *
 * This file is included only when the shortcode for showing
 * the listings is present on the page.
 */

// Utility functions to fetch selected filter values
const helmikohteetFunctions = {
    // Input tags inside a given element ID as an array
    inputsIn: (doc, id) => Array.from(
        doc.getElementById(id)
            .getElementsByTagName('input')
    ),

    // List of selected checkbox values
    selectedValues: (inputs) => inputs
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value),
}

const runHelmikFilters = () => {
    // utility functions
    const fn = helmikohteetFunctions

    // filter based on selected listing types
    const selectedListingTypes = fn.selectedValues(
        fn.inputsIn(document, 'helmik-filter-listing-type')
    )

    // filter based on selected apartment types
    const selectedApartmentTypes = fn.selectedValues(
        fn.inputsIn(document, 'helmik-filter-apartment-type')
    )

    const searchString = document.getElementById('helmik-search').value;
    const minPrice = document.getElementById('helmik-min-price').value;
    const maxPrice = document.getElementById('helmik-max-price').value;
    const minArea = document.getElementById('helmik-min-area').value;
    const maxArea = document.getElementById('helmik-max-area').value;

    // only show matching listings

    const listings = document.getElementsByClassName('helmik-listing')
    for (const lst of listings) {
        // show all by default
        lst.classList.remove('filtered-out')

        // show only search string matching results
        if (
            searchString &&
            !lst.dataset.apartmentAddress.toLowerCase().includes(searchString) &&
            !lst.dataset.apartmentRooms.toLowerCase().includes(searchString)
        ) {
            lst.classList.add('filtered-out')
        }

        if (minPrice && parseFloat(minPrice) > lst.dataset.apartmentPrice) {
            lst.classList.add('filtered-out')
        }

        if (maxPrice && parseFloat(maxPrice) < lst.dataset.apartmentPrice) {
            lst.classList.add('filtered-out')
        }

        if (minArea && parseFloat(minArea) > lst.dataset.apartmentArea) {
            lst.classList.add('filtered-out')
        }

        if (maxArea && parseFloat(maxArea) < lst.dataset.apartmentArea) {
            lst.classList.add('filtered-out')
        }

        // if any listing types selected, only show those
        if (selectedListingTypes.length && !selectedListingTypes.includes(lst.dataset.listingType)) {
            lst.classList.add('filtered-out')
        }

        // if any apartment types selected, only show those
        if (selectedApartmentTypes.length && !selectedApartmentTypes.includes(lst.dataset.apartmentType)) {
            lst.classList.add('filtered-out')
        }
    }
}

window.addEventListener('load', () => {
    const inputs = document.getElementsByClassName('helmik-filter-input');

    for(let i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener('input', function() {
            runHelmikFilters();
        })
    }

    const checkboxes = document.getElementsByClassName('helmik-filter-checkbox');
    for(let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', function() {
            runHelmikFilters();
        })
    }
});
