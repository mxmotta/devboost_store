"use strict";

const IBGE_URL = "https://servicodados.ibge.gov.br/api/v1"

const ibgeApi = async (url, order = 'id', method = 'GET') => {
    return await $.ajax({
        url: `${IBGE_URL}${url}`,
        method: method,
        data: {
            orderBy: order
        },
        success: (data) => data,
        error: () => console.log('Erro ao conectar na api')
    })
}

const getStates = async () => {

    $('#loading_states').css('display', 'inline-block')

    await ibgeApi(`/localidades/estados`, 'nome')
        .then((states) => {
            states.forEach((state) => {
                $('<option>')
                    .val(state.id)
                    .text(state.nome)
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

    await ibgeApi(`/localidades/estados/${state}/municipios`)
        .then((cities) => {
            cities.forEach((city) => {
                $('<option>')
                    .val(city.id)
                    .text(city.nome)
                    .appendTo('#city')
            })
        })
        .catch(() => console.log('Erro ao executar função'))
        .finally(() => {
            $('#loading_cities').css('display', 'none')
        })

}

getStates()