<?php
class Person{
    protected $firstName;
    protected $lastName;
    protected $height;
    protected $gender;
}

class Student extends Person{
    private $scholarship;
    private $university;

    function __construct($firstName, $lastName, $height, $gender, $university, $scholarship){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->height = $height;
        $this->gender = $gender;
        $this->university = $university;
        $this->scholarship = $scholarship;
    }

    function __set($name,$value){
        return $this->$name=$value;
    }

    function __get($name){
        return $this->$name;
    }

    function __toString(){
        return "Name: " . $this->firstName .
                "<br>Last name: " . $this->lastName .
                "<br>Height: " . $this->height .
                "cm<br>Gender: " . $this->gender .
                "<br>University: " . $this->university .
                "<br>Scholarship: $" . $this->scholarship . "<br><br>";
    }
}

class Employee extends Person{
    private $salary;
    private $company;

    function __construct($firstName, $lastName, $height, $gender, $company, $salary){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->height = $height;
        $this->gender = $gender;
        $this->company = $company;
        $this->salary = $salary;
    }

    function __set($name,$value){
        return $this->$name=$value;
    }

    function __get($name){
        return $this->$name;
    }

    function __toString(){
        return "Name: " . $this->firstName .
                "<br>Last name: " . $this->lastName . 
                "<br>Height: " . $this->height . 
                "cm<br>Gender: " . $this->gender . 
                "<br>Company: " . $this->company . 
                "<br>Salary: $" . $this->salary . "<br><br>";
    }
}

class Calculator {
    private $x;
    private $y;

    function __construct($x,$y){
        $this->x=$x;
        $this->y=$y;
    }

    function addition(){
        return $this->x+$this->y;
    }
    function subtraction(){
        return $this->x-$this->y;
    }
    function multiplication (){
        return $this->x*$this->y;
    }
    function division(){
        if($this->y!=0){
            return $this->x/$this->y;
        }else{
            return "Division by zero is not allowed";
        } 
    }

    function __toString(){
        return "Addition: " . $this->addition() . 
                "<br>" . "Subtraction: " . $this->subtraction() . 
                "<br>" . "Multiplication: " . $this->multiplication() . 
                "<br>" .  "Division: " . $this->division() . "<br>";
    }
}

$student = new Student("Marko","Milinkovic",184,"Musko","Visoka skola elektrotehnike i racunarstva",100);
$employee = new Employee("Stefan","Obradovic",182,"Musko","Knjaz Milos", 1000);
echo $student;
echo $employee;

$calc = new Calculator(5,6);
echo $calc;
?>