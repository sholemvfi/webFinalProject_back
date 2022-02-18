<?php
    class Movie {
        private $table = 'movieinfo';
        public $id;
        public $name;
        public $description;
        public $year;
        public $img;
        private $connection;
        /**
         * @var mixed|void
         */
        public $searchquery;

        public function __construct($database){
            $this->connection = $database;
        }

        public function read() {
            $query = 'SELECT * from ' . $this->table;
            $prepared = $this->connection->prepare($query);
            $prepared->execute();
            return $prepared;
        }

        public function readById() {
            $query = 'SELECT * from ' . $this->table . ' m where m.id=? limit 0,1';
            $prepared = $this->connection->prepare($query);
            $prepared->bindParam(1, $this->id);
            $prepared->execute();
            $info = $prepared->fetch(PDO::FETCH_ASSOC);
            $this->id = $info['id'];
            $this->name = $info['name'];
            $this->year = $info['year'];
            $this->description = $info['description'];
            $this->img = $info['img'];
            return $prepared;
        }

        public function create() {
            $query = 'insert into ' . $this->table . ' (name,year,description,img) values(:name,:year,:description,:img);';

            $prepared = $this->connection->prepare($query);
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->year = htmlspecialchars(strip_tags($this->year));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->img = htmlspecialchars(strip_tags($this->img));
            $prepared->bindParam(':name', $this->name);
            $prepared->bindParam(':description', $this->description);
            $prepared->bindParam(':year', $this->year);
            $prepared->bindParam(':img', $this->img);

            if ($prepared->execute()) {
                return true;
            } else {
                printf("something is wrong: %s.\n", $prepared->error);
                return false;
            }
        }

        public function search() {
            $query = 'select * from ' . $this->table . ' where name=:name or year=:year';
            $prepared = $this->connection->prepare($query);
            if (isset($this->searchquery)) {
                $prepared->bindParam(':name', $this->searchquery);
                $prepared->bindParam(':year', $this->searchquery);
            } else {
                $query = 'select * from ' . $this->table;
            }

            $prepared->execute();
            return $prepared;
        }

        public function delete() {
            $query = 'delete from ' . $this->table . ' where id=:id';
            $prepared = $this->connection->prepare($query);
            $prepared->bindParam(':id', $this->id);
            $prepared->execute();
            return $prepared;
        }

        public function edit() {
            $query = 'update ' . $this->table . ' set name=:name, year=:year, description=:description, img=:img where id=:id;';
            $prepared = $this->connection->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->year = htmlspecialchars(strip_tags($this->year));
            $this->img = htmlspecialchars(strip_tags($this->img));
            $prepared->bindParam(':id', $this->id);
            $prepared->bindParam(':name', $this->name);
            $prepared->bindParam(':year', $this->year);
            $prepared->bindParam(':description', $this->description);
            $prepared->bindParam(':img', $this->img);

            if ($prepared->execute()) {
                return true;
            } else {
                printf("something is wrong: %s.\n", $prepared->error);
                return false;
            }
        }

    }