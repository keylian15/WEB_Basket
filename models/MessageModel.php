<?php
/**
 * Modèle pour gérer le message "Hello World"
 */
class MessageModel {
    /**
     * Récupère le message à afficher
     *
     * @return string Le message "Hello World"
     */
    public function getMessage() {
        // Dans une application réelle, cela pourrait provenir d'une base de données
        // ou d'une autre source de données
        return "Hello World!";
    }
}