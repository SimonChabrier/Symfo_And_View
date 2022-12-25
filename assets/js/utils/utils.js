const utils = {

    // afficher une date au format 01 janvier 2023
    formatFrenchDate(dateTime) {
        return new Date(dateTime).toLocaleDateString('fr-FR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    },

    // afficher une date au format 01/01/2023
    formatDate(dateTime) {
        return new Date(dateTime).toLocaleDateString('fr-FR', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        });
    },
    
    // afficher la date et l'heure au format 01/01/2023 12:00
    formatDateTime(dateTime) {
        return new Date(dateTime).toLocaleDateString('fr-FR', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        });
    },

    // afficher l'heure de la date au format 12:00
    formatTime(dateTime) {
        const date =  new Date(dateTime).toLocaleTimeString('fr-FR', {
            hour: '2-digit',
            minute: '2-digit'
        });
        return date.replace(':', 'h');
    }


}

export default utils;