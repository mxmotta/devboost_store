"use strict";

const IBGE_URL = "http://devboost_store.local/api.php?page="

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
    // $('#state').data('selected')

    await api(`states`, {
        orderBy: 'name,asc'
    })
        .then((data) => JSON.parse(data))
        .then((states) => {
            states.forEach((state) => {
                let option = $('<option>')
                    .val(state.id)
                    .text(state.name)
                    .appendTo('#state')

                if ($('#state').data('selected') == state.id) {
                    option.attr('selected', true)
                }
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
        .then((data) => JSON.parse(data))
        .then((cities) => {
            cities.forEach((city) => {
                let option = $('<option>')
                    .val(city.id)
                    .text(city.name)
                    .appendTo('#city')

                if ($('#city').data('selected') == city.id) {
                    option.attr('selected', true)
                }
            })
        })
        .catch(() => console.log('Erro ao executar função'))
        .finally(() => {
            $('#loading_cities').css('display', 'none')
        })

}

getStates()

if ($('#state').data('selected')) {
    getCity($('#state').data('selected'))
}

$(function () {
    $('.money').maskMoney({
        prefix: 'R$ ',
        thousands: '.',
        decimal: ',',
        allowZero: true
    })
    $('.money').trigger('focus')
})