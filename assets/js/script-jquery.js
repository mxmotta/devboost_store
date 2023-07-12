"use strict";

const IBGE_URL = "http://localhost/devboost_store/api.php?page="

const api = async (url, params = {}, method = 'GET') => {
    return await $.ajax({
        url: `${IBGE_URL}${url}`,
        method: method,
        data: params,
        success: (data) => data,
        error: () => console.log('Erro ao conectar na api')
    })
}

const getStates = async () => {

    $('#loading_states').css('display', 'inline-block')

    await api(`states`, {
        orderBy: 'name,asc'
    })
        .then((states) => {
            states.forEach((state) => {
                $('<option>')
                    .val(state.id)
                    .text(state.name)
                    .appendTo('#state')
            })
        })
        .catch(() => console.log('Erro ao executar função'))
        .finally(() => {
            $('#loading_states').css('display', 'none')
        })

    $('#state').on('change', (event) => {
        let state = event.target.value
        getCity(state)
    })
}

const getCity = async (state) => {

    $('#loading_cities').css('display', 'inline-block')

    $('#city').html('')
    $('<option>')
        .val('')
        .text('Selecione uma cidade')
        .appendTo('#city')

    await api(`cities`, {
        orderBy: 'name,asc',
        state_id: state
    })
        .then((cities) => {
            cities.forEach((city) => {
                $('<option>')
                    .val(city.id)
                    .text(city.name)
                    .appendTo('#city')
            })
        })
        .catch(() => console.log('Erro ao executar função'))
        .finally(() => {
            $('#loading_cities').css('display', 'none')
        })

}

getStates()