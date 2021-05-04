/**
 * Helmikohteet shortcode listing filter
 *
 * This file is included only when the shortcode for showing
 * the listings is present on the page.
 */

window.addEventListener('load', () => {
    document.getElementById('helmik-filter-form')
        .addEventListener('submit', (event) => {
            // filter based on selected listing types

            const listingTypeCheckboxes = Array.from(document.getElementById('helmik-filter-listing-type')
                .getElementsByTagName('input'))
            const showListingTypes = listingTypeCheckboxes
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value)

            // filter based on selected apartment types

            const apartmentTypeCheckboxes = Array.from(document.getElementById('helmik-filter-apartment-type')
                .getElementsByTagName('input'))
            const showApartmentTypes = apartmentTypeCheckboxes
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value)

            // only show matching listings

            const listings = document.getElementsByClassName('helmik-listing')
            for (const lst of listings) {
                // show all by default
                lst.classList.remove('filtered-out')

                // if any listing types selected, only show those
                if (showListingTypes.length && !showListingTypes.includes(lst.dataset.listingType)) {
                    lst.classList.add('filtered-out')
                }

                // if any apartment types selected, only show those
                if (showApartmentTypes.length && !showApartmentTypes.includes(lst.dataset.apartmentType)) {
                    lst.classList.add('filtered-out')
                }
            }

            // do not submit the form
            event.preventDefault()
        })
})
