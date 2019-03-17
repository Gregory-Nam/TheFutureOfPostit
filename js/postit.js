class Postit {
    constructor(postit,index)
    {
        this.nom = postit.NOM;
        this.idBd = postit.ID;
        this.idPostitUser = index;
    }


    nomToHtml(){
        return this.nom;
    }

    getIdBd(){
        return this.idBd;
    }

    getIdPostitUser(){
        return this.idPostitUser;
    }
}