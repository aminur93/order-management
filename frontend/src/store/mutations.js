export const ADD_REGISTER = (state, data) => {
    state.success_message = data.message;
    state.success_status = data.status;
};

export const SET_TOKEN = (state, token) => {
    state.token = token;
    localStorage.setItem('token', token);
};

export const SET_USER = (state, data) => {
    state.user = data
    localStorage.setItem('user', JSON.stringify(data));
};

export const clearToken = (state) => {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    state.token = '';
    state.user = '';
};