import axios from 'axios';

//const API_URL = 'https://127.0.0.1:8000/api/login';
const API_URL = 'https://vueusers.simschab.cloud/login';

const authServices =  {

async getAuth(user) {
    console.log('getAuth');

    const data = { 
        "security": {
            "credentials": {
                "login": user.username,
                "password": user.password
            }
        }
    }

    return axios.post(API_URL, data)
    .then(response => { 
        console.log(`${response.data.username} is logged in`);
        console.log(`${response.data}`);
        localStorage.setItem('token', JSON.stringify(response.data.token)); 
        localStorage.setItem('username', JSON.stringify(response.data.username)); 
    })
},


async killAuth() {
    console.log('killAuth');

    //return await axios.post('https://127.0.0.1:8000/logout').then(response => {
    return await axios.post('https://vueusers.simschab.cloud/logout').then(response => {

        console.log(response.status);

        localStorage.removeItem('token');
        localStorage.removeItem('username');

        if(!localStorage.getItem('token') && !localStorage.getItem('username')) {
        return true;
        }
    }).then(() => {
        //window.location.reload();
    })
},

// check if token exists in local storage
checkToken() {
    if(localStorage.getItem('token') && localStorage.getItem('username')) {
        console.log('token and username exists');
        return true;
    } else {
        console.log('token and username does not exist');
        return false;
    }
},

// use the token from local storage to make authenticated requests headers
authenticateUser() {
    console.log('authenticateUser');

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