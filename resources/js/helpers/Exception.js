import User from './User'

class Exception {
    handle(error) {
        this.isExpired(error.response.data.error)
    }
    isExpired(error) {
        switch (error) {
            case 'Token is invalid':
            case 'Token is expired':
                console.log('here')
                User.logout()
                break
        }
    }
}

export default Exception = new Exception()
