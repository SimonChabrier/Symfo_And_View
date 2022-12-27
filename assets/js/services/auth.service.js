import axios from 'axios';

const API_URL = 'https://127.0.0.1:8000/api/login_check';

const authServices =  {

async getAuth(user) {
    console.log('getAuth');

    const data = { username: user.username, password: user.password }
    return axios.post(API_URL, data)
    .then(response => { localStorage.setItem('token', JSON.stringify(response.data.token)); })
},


killAuth() {
    localStorage.removeItem('token');
    if(!localStorage.getItem('token')) {
    return true;
    }
},

checkToken() {
    console.log('checkToken');

    if(localStorage.getItem('token')) {
        return true;
    } else {
        return false;
    }
},
// check token in local storage
checkAuth() {
    console.log('checkAuth');

    // récupération du token dans le local storage
    let token = JSON.parse(localStorage.getItem('token'));
    // si le token existe on retourne un objet avec le token
    if (token) {
        const headers = { "Authorization" : `Bearer ${token}` };
        return headers;
    } 
    // sinon on retourne un objet vide
    return {};
},

}

export default authServices;