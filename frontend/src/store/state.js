export default {

    //Local development url
    apiUrl: "http://localhost:8000/api/",
    serverPath: "http://localhost:8000",

    //production server url

    //root state data property
    token: localStorage.getItem("token") || "",
    user: localStorage.getItem("user") || "",
    success_message: '',
    errors: {},
    error_message: '',
    error_status: '',
    success_status: ''
}