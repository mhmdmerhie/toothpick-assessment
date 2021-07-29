class ApiCaller {
    static setToken(token) {
        window.localStorage.setItem('token', token);
    }

    static getToken() {
        return window.localStorage.getItem('token');
    }

    async apiFetch(method, resource, token = false, body = undefined, queries = undefined) {
        return new Promise((resolve, reject) => {
            let jwt = undefined;
            if (token)
                jwt = 'Bearer ' + ApiCaller.getToken();
            //"http://127.0.0.1:8000/"
            if (queries && Array.isArray(queries)) {
                resource += "?";
                queries.forEach(el => {
                    resource += el.key;
                    resource += "=";
                    resource += el.value;
                    resource += "&";
                })
            }
            fetch(resource, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept' : 'application/json',
                },
                body: JSON.stringify(body)
            })
                .then(response => {
                    if (response.status !== 200)
                       throw new Error()
                    else
                        return response.json();
                })
                .then((res) => {
                    resolve(res);
                })
                .catch(err => {
                    reject(err);
                });
        });
    }

    async register(name,email,phone,password){
        return new Promise((resolve,reject)=>{
            let body = {
                name:name,
                email:email,
                phone:phone,
                password:password
            }
            this.jfetch("POST","api/signup",false,body,[])
                .then(res=>{
                    ApiCaller.setToken(res.token);
                    resolve(res);
                })
                .catch(err=>{
                    reject(err);
                })
        })

    }

    async login(email,password){
        return new Promise((resolve,reject)=>{
            let body = {
                email:email,
                password:password
            }
            this.jfetch("POST","api/login",false,body,[])
                .then(res=>{
                    ApiCaller.setToken(res.token);
                    resolve(res);
                })
                .catch(err=>{
                    reject(err);
                })
        })

    }
}
export default ApiCaller;
