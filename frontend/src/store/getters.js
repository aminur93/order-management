export const authenticated = (state) => {
    return state.token && state.admin_user
};

export const AuthToken = (state) => {
    return state.token;
};