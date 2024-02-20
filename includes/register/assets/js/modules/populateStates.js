import { featchStates } from './populateCstTeam'

const dom = {
    stateSelect: $('#states'),
    countrySelect: $('#countries')
}

const init = () => {
    dom.countrySelect.on('change', featchStatesFromCountries);
}

const featchStatesFromCountries = async (e) => {
    // Remove old results 

    const stateSelect = $('.state-option');

    if (stateSelect.length) {
        stateSelect.remove()
    }

    const cstStateOptions = $('.cst-state-option');

    if (cstStateOptions.length) {
        cstStateOptions.remove()
        $('#cst_team').prop('selectedIndex', 0)
    }

    const countryCode = $(e.currentTarget).val();

    if (countryCode) {
        const formData = new FormData()
        formData.append('action', 'state_select_populate')
        formData.append('countryCode', countryCode)
        formData.append('nonce', appRegister.ajaxNonce)

        const request = await fetch(appRegister.ajaxUrl, {
            method: 'POST',
            body: formData
        })

        const response = await request.json()
        if (response.success === true) {
            const states = response.data.states;
            if (states.length === 0) {
                const option = $("<option value='No states available' class='state-option'>No states available</option>");
                dom.stateSelect.append(option)
                dom.stateSelect.prop('selectedIndex', 1);
                featchStates(null, false, countryCode);
            }
            else {
                if (states !== undefined) {
                    $.each(states, (stateCode, teamName) => {
                        const option = $("<option class='state-option'> </option>");
                        option.val(stateCode);
                        option.text(teamName);
                        dom.stateSelect.append(option)
                        dom.stateSelect.prop('selectedIndex', 0);
                    })
                }
            }
        }
    }
}

export default init;