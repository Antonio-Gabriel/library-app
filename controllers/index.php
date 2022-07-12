<?php

// Generic requires
require_once dirname(__DIR__) . "/configs/Model.php";
require_once dirname(__DIR__) . "/configs/Sql.php";
require_once dirname(__DIR__) . "/utils/redirect.php";

// Common
require_once dirname(__DIR__) . "/common/Entity.php";
require_once dirname(__DIR__) . "/common/Result.php";

// Interfaces
require_once dirname(__DIR__) . "/interfaces/IGenreRepository.php";
require_once dirname(__DIR__) . "/interfaces/IAuthorRepository.php";
require_once dirname(__DIR__) . "/interfaces/IBookRepository.php";

// Genre entity
require_once dirname(__DIR__) . "/entities/Genre.php";
require_once dirname(__DIR__) . "/entities/Author.php";
require_once dirname(__DIR__) . "/entities/Book.php";

// Services
require_once dirname(__DIR__) . "/services/GenreService.php";
require_once dirname(__DIR__) . "/services/AuthorService.php";
require_once dirname(__DIR__) . "/services/BookService.php";
require_once dirname(__DIR__) . "/services/UserService.php";

// Middleware
require_once dirname(__DIR__) . "/middleware/security/Hash.php";
