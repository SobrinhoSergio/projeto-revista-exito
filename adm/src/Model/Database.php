<?php



namespace Friweb\CMS\Model;



class Database {



	// realiza conexão com o banco

	public static function getConnection() {



	    // hospedado em friweb.tk

//		$conn = mysqli_connect("localhost", "friwebserver", "cKEr!aKcm?GM", "friwebse_exitorio");



        // hospedado na máquina local

       $conn = mysqli_connect("localhost", "root", "", "wwwerio_2021");



        // iuri0138

//        $conn = mysqli_connect("localhost", "wwwexitoriocom", "EX@30/10-t]r", "wwwexito_exitorio");



        // exitorio 2021

      //  $conn = mysqli_connect("localhost", "wwwerio", "EX@t17/3-]!?", "wwwerio_2021");



		if ($conn->connect_error) {

			die("Erro de conexão: " . $conn->connect_error);

		}



		// exportação

//		$conn->set_charset("utf-8");

//        $conn->query("SET NAMES 'utf8mb4'");

//        $conn->query('SET character_set_connection=utf8mb4');

//        $conn->query('SET character_set_client=utf8mb4');

//        $conn->query('SET character_set_results=utf8mb4');



		return $conn;

	}



	// retorna query

	public static function getResultFromQuery($sql) {

        $conn = self::getConnection();

        $result = $conn->query($sql);

        $conn->close();

        return $result;

    }

}