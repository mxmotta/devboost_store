"use strict";

const IBGE_URL = "https://servicodados.ibge.gov.br/api/v1"

const ibgeApi = async (url, order = 'id') => {
    return await fetch(`${IBGE_URL}${url}?orderBy=${order}`)
        .then((res) => res.json())
        .catch(() => console.log('Erro ao conectar na api'))
}

const getStates = async () => {

    let stateEl = document.getElementById('state')
    let loading_states = document.getElementById('loading_states')
    loading_states.style.display = 'inline-block'

    await ibgeApi(`/localidades/estados`, 'nome')
        .then((states) => {
            states.forEach((state) => {
                let option = document.createElement('option')
                option.value = state.id
                option.label = state.nome
                stateEl.append(option)
            })
        })
        .catch(() => console.log('Erro ao executar função'))
        .finally(() => {
            loading_states.style.display = 'none'
        })


    stateEl.addEventListener('change', (event) => {
        let state = event.target.value
        getCity(state)
    })
}

const getCity = async (state) => {

    let cityEl = document.getElementById('city')

    let loading_cities = document.getElementById('loading_cities')
    loading_cities.style.display = 'inline-block'

    let option = document.createElement('option')
    option.value = ''
    option.label = 'Selecione uma cidade'
    cityEl.replaceChildren(option)

    await ibgeApi(`/localidades/estados/${state}/municipios`)
        .then((cities) => {
            cities.forEach((city) => {
                let option = document.createElement('option')
                option.value = city.id
                option.label = city.nome
                cityEl.append(option)
            })
        })
        .catch(() => console.log('Erro ao executar função'))
        .finally(() => {
            loading_cities.style.display = 'none'
        })

}

getStates()