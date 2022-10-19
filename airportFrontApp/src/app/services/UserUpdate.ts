export class UserUpdate {
    private  id:any
    private  username: string ;
    private nom: string;
    private prenom : string;
    private  email: string;
    private password: string;
    private telephone : string;
    private roles:any;

    constructor (id:any, username:any, nom:any, prenom:any, email:any, password:any, telephone:any, roles:any){
        this.id=id
        this.username=username
        this.nom=nom
        this.prenom=prenom
        this.email=email
        this.password=password
        this.telephone=telephone
        this.roles=roles
    }

}