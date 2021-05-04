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

window.addEventListener('load', () => {
    document.getElementById('helmik-filter-form')
        .addEventListener('submit', (event) => {
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

            // only show matching listings

            const listings = document.getElementsByClassName('helmik-listing')
            for (const lst of listings) {
                // show all by default
                lst.classList.remove('filtered-out')

                // if any listing types selected, only show those
                if (selectedListingTypes.length && !selectedListingTypes.includes(lst.dataset.listingType)) {
                    lst.classList.add('filtered-out')
                }

                // if any apartment types selected, only show those
                if (selectedApartmentTypes.length && !selectedApartmentTypes.includes(lst.dataset.apartmentType)) {
                    lst.classList.add('filtered-out')
                }
            }

            // do not submit the form
            event.preventDefault()
        })
})
