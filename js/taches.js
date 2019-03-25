class Tache{
    constructor(tache){
        this.tache = tache.INTITULE;
        this.date = tache.DATE;
        this.idtacheuser = tache.NUM;
        this.etat = tache.ETAT;
    }

    toHtml(){
        return this.tache;
    }

    getDate(){
        return this.date;
    }

    getIdTacheUser(){
        return this.idtacheuser;
    }

    getEtat(){
        return this.etat;
    }

}