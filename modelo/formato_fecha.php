<?php
date_default_timezone_set('America/Bogota'); 
                    function fecha(){
                        $fecha_dia=date("d");
                        $fecha_mes=date("m");
                        $fecha_year=date("Y");
                        $dia_semana=[
                        "Monday"=>"Lunes",
                        "Tuesday" => "Martes", 
                        "Wednesday" => "Miércoles",
                        "Thursday" => "Jueves",
                        "Friday"=>"Viernes",
                        "Saturday"=>"Sábado",
                        "Sunday" => "Domingo"
                        ];

                        $mese_year=[
                            "01"=>"enero",
                            "02"=>"febrero",
                            "03"=>"marzo",
                            "04"=>"abril",
                            "05"=>"mayo",
                            "06"=>"junio",
                            "07"=>"julio",
                            "08"=>"agosto",
                            "09"=>"septiembre", 
                            "10"=>"octubre",
                            "11" => "noviembre",
                            "12"=>"diciembre"
                        ];

                        $fecha_final=$dia_semana [date("l")]." ".$fecha_dia." de ".$mese_year [$fecha_mes]." de ". $fecha_year;
                        return $fecha_final;
                    }