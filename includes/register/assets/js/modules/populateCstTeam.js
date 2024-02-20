const dom = {
    stateSelect: $('#states'),
    cstTeamSelect: $('#cst_team')
}

const init = () => {
    dom.stateSelect.on('change', (e) => featchStates(e));
}

export const featchStates = async (e = null, isEvent = true, stateCodeParam = null) => {
    
    // Remove old results 

    const cstStateOptions = $('.cst-state-option');

    if(cstStateOptions.length) {
        cstStateOptions.remove()
        $('#cst_team').prop('selectedIndex', 0)
    }

    const stateCode = isEvent === true ? $(e.currentTarget).val() : stateCodeParam

    if (stateCode) {
        const formData = new FormData()
        formData.append('action', 'cst_team_populate')
        formData.append('stateCode', stateCode)
        formData.append('nonce', appRegister.ajaxNonce)

        const request = await fetch(appRegister.ajaxUrl, {
            method: 'POST',
            body: formData
        })

        const response = await request.json()
        if(response.success === true) {
            const teams = response.data.teams;
            if(teams !== undefined) {
                $.each(teams, (index, teamName) => {
                    const option = $("<option class='cst-state-option'> </option>");
                    option.val(teamName);
                    option.text(teamName);
                    dom.cstTeamSelect.append(option)
                })
            }
        }
    }
}

export default init;