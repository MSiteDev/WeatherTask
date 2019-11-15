import { api } from '../../api';
import {FIND_CITY, FINDING_FAILED, FINDING_SUCCESS, SEARCH_SUCCESS} from '../types';

export const fetchTown = value => async dispatch => {
    try {
        const res = await api.get(`/cities/find/name?q=${value}`);
        dispatch({type: FIND_CITY, payload: res.data})
    } catch (e) {
        console.log(e);
    }
};

export const searchPlaces = value => dispatch => {

    api.get(`/places/search?q=${value}`)
        .then(res => {
            dispatch({
                type: SEARCH_SUCCESS,
                payload: res.data.data
            })
        })
};

export const findPlace = value => dispatch => {

    api.get("/places/" + (Number.isInteger(value) ? "" : "find?q=") + value)
        .then(res => {
            dispatch({
                type: FINDING_SUCCESS,
                payload: res.data.data
            })
        })
        .catch(error => {
            dispatch({type: FINDING_FAILED})
        })
};
