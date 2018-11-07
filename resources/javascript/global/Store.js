
// Simple store a la redux
class Store {
    getState() {
        return this.state;
    }
    setState(key, value) {
        this.state[key] = {
            ...this.state[key],
            ...value,
        }
    }
}

export default Store;