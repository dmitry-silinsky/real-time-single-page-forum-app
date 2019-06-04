import Token from './Token'
import AppStorage from './AppStorage'
import Exception from "./Exception";

class User {
    async login(payload) {
        try {
            const response = await axios.post('/api/auth/login', payload)
            this.responseAfterLogin(response)
        } catch(e) {
            Exception.handle(e)
        }
    }
    async signup(payload) {
        try {
            const response = await axios.post('/api/auth/signUp', payload)
            this.responseAfterLogin(response)
        } catch (e) {
            Exception.handle(e)
        }
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
            return Token.isValid(storedToken) ? true : this.logout()
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
    own(id) {
        return this.id() === id
    }
    isAdmin() {
        return this.id() === 11
    }
}

export default User = new User()
