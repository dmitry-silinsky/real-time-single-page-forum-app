import Token from './Token'
import AppStorage from './AppStorage'

class User {
    login(payload) {
        axios.post('/api/auth/login', payload)
            .then(response => this.responseAfterLogin(response))
            .catch(error => {
                if (error.response) {
                    console.log(error.response.data)
                }
            })
    }
    signup(payload) {
        axios.post('/api/auth/signUp', payload)
            .then(response => this.responseAfterLogin(response))
            .catch(error => {
                if (error.response) {
                    console.log(error.response.data)
                }
            })
    }
    responseAfterLogin(response) {
        const token = response.data.access_token
        const username = response.data.user
        if (Token.isValid(token)) {
            AppStorage.store(username, token)
        }
    }
    hasToken() {
        const storedToken = AppStorage.getToken()
        if (storedToken) {
            return Token.isValid(storedToken)
        }
        return false
    }
    loggedIn() {
        return this.hasToken()
    }
    logout() {
        return AppStorage.clear()
    }
    name() {
        if (this.loggedIn()) {
            return AppStorage.getUser()
        }
    }
    id() {
        if (this.loggedIn()) {
            const payload = Token.payload(AppStorage.getToken())
            return payload.sub
        }
    }
}

export default User = new User()
