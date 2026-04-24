-- copier le fichier dans le conteneur: docker cp smartLearn.sql aw_db:/smartLearn.sql
-- Entrer dans le conteneur MySQL docker exec -it aw_db bash
-- exécuter ton fichier SQL mysql -u root -p < /smartLearn.sql


-- Suppression et création de la base
DROP DATABASE IF EXISTS smart_learn;
CREATE DATABASE smart_learn
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE smart_learn;

-- TABLE UTILISATEURS
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(50) NOT NULL,
    forename VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('teacher', 'student') NOT NULL DEFAULT 'student'
);

-- TABLE COURS
CREATE TABLE course (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    descriptive TEXT NOT NULL,
    delay DATE NOT NULL,
    date_start DATE NOT NULL,
    date_end DATE NOT NULL,
    time_start TIME NOT NULL,
    time_end TIME NOT NULL,
    days VARCHAR(100) NOT NULL,
    period INT NOT NULL,
    sites VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    teacher_id INT NOT NULL,
    
    CONSTRAINT fk_course_teacher
        FOREIGN KEY (teacher_id)
        REFERENCES user(id)
        ON DELETE CASCADE
);

-- TABLE INSCRIPTIONS
CREATE TABLE enrollment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT unique_user_course 
        UNIQUE (user_id, course_id),

    CONSTRAINT fk_enroll_user
        FOREIGN KEY (user_id)
        REFERENCES user(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_enroll_course
        FOREIGN KEY (course_id)
        REFERENCES course(id)
        ON DELETE CASCADE
);

CREATE TABLE enrollmentstatus (
    id INT PRIMARY KEY,
    inscription_status   ENUM('white', 'green', 'red') NOT NULL DEFAULT 'white',
    admissibilite_status ENUM('white', 'green', 'red') NOT NULL DEFAULT 'white',
    paiement_status      ENUM('white', 'green', 'red') NOT NULL DEFAULT 'white',
    realisation_status   ENUM('white', 'green', 'red') NOT NULL DEFAULT 'white',
    certification_status ENUM('white', 'green', 'red') NOT NULL DEFAULT 'white',

    CONSTRAINT fk_status_enrollment
        FOREIGN KEY (id)
        REFERENCES enrollment(id)
        ON DELETE CASCADE
);

INSERT INTO user (email, name, forename, password, role) VALUES
('dm@gmail.com', 'Dolci', 'Marco', '$2y$12$sFAQG1nipsthWhAOULtbeuQ2Q8WIAdQU5OFtRQh1sBemLObl8Z7rW', 'student'),
('dc@gmail.ch', 'Debons', 'Christophe', '$2y$12$sFAQG1nipsthWhAOULtbeuQ2Q8WIAdQU5OFtRQh1sBemLObl8Z7rW', 'student'),
('mh@gmail.ch', 'Mercier', 'Hugues', '$2y$12$sFAQG1nipsthWhAOULtbeuQ2Q8WIAdQU5OFtRQh1sBemLObl8Z7rW', 'teacher'),
('sm@gmail.ch', 'Schaefer', 'Marc', '$2y$12$sFAQG1nipsthWhAOULtbeuQ2Q8WIAdQU5OFtRQh1sBemLObl8Z7rW', 'teacher');

INSERT INTO course (
    name, descriptive, delay, date_start, date_end,
    time_start, time_end, days, period, sites, price, teacher_id
) VALUES (
'REST et application à un LLM',
'- Concepts de base des LLM et du LLM fourni
- Concepts de base du REST 
- Exemple de l’API REST fournie
- Déploiement de cette API (LLM, Docker local)
- Utilisation de l’API avec des scripts simples python (Manipulation des données en entrée et en sortie)
- Mécanismes d’authentification basés entêtes HTTP avec exemples d’attaques et de code en python (auth-basic, auth-digest, signed cookie, token, JWT
- Eléments avancés
    - REST maturityleve
    - Documentation avec OpenAPI
    - Objets complexes via query language JSON avec graphQL',
'2026-01-15',
'2026-02-01',
'2026-04-30',
'08:30',
'12:00',
'Vendredi',
14,
'HE-Arc Neuchâtel',
600.00,
3
);


INSERT INTO course (
    name, descriptive, delay, date_start, date_end,
    time_start, time_end, days, period, sites, price, teacher_id
) VALUES (
'Protocoles Internet et pages Web statiques avec HTML et CSS',
'- Fonctionnement des protocoles du web (architecture client/serveur, protocoles applicatifs TCP/IP, fonctionnement du web, performance HTTP/1.1 vs HTTP/2.0)
- Structurer et valider un document avec HTML5
- Encodage (échappements, entités, etc.)
- Présenter un document avec CSS3
- Utilisation d''un préprocesseur CSS (SASS, SCSS)
- Media queries pour l''impression
- Approches Mobile First et Graceful Desktop Degradation
- Media queries pour rendre un site responsive (compatible mobile)
- Utilisation d''un framework CSS (Bootstrap)
- Intégration de widgets via iframes (ex. vidéos YouTube)',
'2026-02-10',
'2026-03-01',
'2026-05-15',
'18:00',
'21:00',
'Jeudi',
26,
'HE-Arc Neuchâtel',
1200.00,
3
);


INSERT INTO course (
    name, descriptive, delay, date_start, date_end,
    time_start, time_end, days, period, sites, price, teacher_id
) VALUES (
'Développement frontend Javascript',
'- Introduction et contexte d''une application JavaScript
- Cycle de vie et optimisation d''applications JavaScript
- Déploiement d''une application JavaScript
- Notion d''objet et manipulation du DOM en JavaScript
- Langage JavaScript : structures, méthodes, événements, objets du navigateur, boîtes de dialogue, programmation événementielle et fonctionnelle
- Avantages de TypeScript pour produire du code de qualité et mieux structuré, générant du code JavaScript propre',
'2026-04-10',
'2026-05-01',
'2026-07-15',
'13:30',
'17:00',
'Samedi',
26,
'HE-Arc Neuchâtel',
1200.00,
3
);

INSERT INTO course (
    name, descriptive, delay, date_start, date_end,
    time_start, time_end, days, period, sites, price, teacher_id
) VALUES (
'Formats du Web',
'- Introduction aux formats de données du web (JSON, XML, CSV, etc.) et à leur utilisation dans les applications web
- Formats XML et JSON : modélisation, validation de formats et de grammaires
- Le rôle de REST dans les applications web
- Modélisation et validation des données en JSON et XML (outils en ligne, exemples Python)
- Développement d''un consommateur REST en Python avec JSON et XML',
'2026-05-20',
'2026-06-05',
'2026-08-10',
'09:00',
'12:00',
'Mercredi',
25,
'HE-Arc Neuchâtel',
1200.00,
3
);

INSERT INTO course (
    name, descriptive, delay, date_start, date_end,
    time_start, time_end, days, period, sites, price, teacher_id
) VALUES (
'Conception, réalisation et déploiement backend avec PHP et outils communautaires',
'- Comparaison entre langages classiques et langages de script web : outils et puissance, particularités et dangers ; méthodes et cycles de développement
- Développement multiplateforme avec des conteneurs Docker (option CI/CD)
- Utilisation de forges logicielles et de l''outil de contrôle de version Git
- Le langage PHP : syntaxe, POO, programmation fonctionnelle, sécurité, tests, documentation, internationalisation, Composer, expressions régulières, traitement de formulaires et validation
- Le modèle MVC en pratique (écriture d''un mini-framework)
- Interfaçage orienté-objet à un SGBD avec PDO
- Amélioration simple de l''utilisabilité et de l''interactivité avec JavaScript
- Production de JSON en PHP
- Documentation du code en Markdown
- Déploiement',
'2025-03-01',
'2025-03-01',
'2025-03-01',
'18:15',
'21:30',
'Mardi',
26,
'HE-Arc Neuchâtel',
1200.00,
4
);

INSERT INTO course (
    name, descriptive, delay, date_start, date_end,
    time_start, time_end, days, period, sites, price, teacher_id
) VALUES (
'Déploiement de solutions logicielles',
'- Architecture d''un système informatique (CPU, mémoire, périphériques, système d''exploitation, système de fichiers, processus, droits d''accès DAC)
- Architecture d''une application (bibliothèques, frameworks, services réseau, parallélisme)
- Introduction au contrôle de version avec Git
- Architecture du réseau (modèle OSI, modèle IP, architectures applicatives, couches TCP/UDP, couche application) et applications avec netcat, Python et Docker
- Principes et typologie de la virtualisation (conteneurs, lourde, paravirtualisation) et applications avec VirtualBox, WSL2+GUI et le cloud (IaaS, PaaS, SaaS) ; solutions cloud-agnostic vs cloud-native
- Architecture d''une solution logicielle client-serveur, avec application à Docker, Git/GitHub et déploiement par l''étudiant-e
- Mathématique et logique de l''ordinateur / types de données de base (logiques et arithmétiques) en Python
- Formats des données (bases théoriques et pratiques d''Unicode, UTF-8 et jeux nationaux) avec application en bash (file, recode) et éditeur de texte
- Le langage de script bash et les commandes de base UNIX (sed, awk, etc.) et application au parallélisme d''exécution
- Concepts de base de la sécurité',
'2026-06-10',
'2026-07-01',
'2026-10-15',
'08:15',
'11:45',
'Mercredi',
40,
'HE-Arc Neuchâtel',
1800.00,
4
);

INSERT INTO course (
    name, descriptive, delay, date_start, date_end,
    time_start, time_end, days, period, sites, price, teacher_id
) VALUES (
'Développement et conception orienté(e)s objet avec Python',
'- Bases de la programmation procédurale en Python
- Structures de données en Python (list, dict, tuple, set, etc.)
- Concepts de la programmation orientée objet (POO)
- Classes et objets
- Encapsulation, héritage et polymorphisme
- Méthodes de classe et méthodes statiques
- Entrées-sorties (fichiers, flux)
- Modules et environnements virtuels
- Gestion des exceptions
- Pratique du contrôle de version avec Git',
'2026-08-20',
'2026-09-05',
'2026-11-25',
'14:00',
'17:30',
'Mercredi',
52,
'HE-Arc Neuchâtel',
2400.00,
4
);

INSERT INTO course (
    name, descriptive, delay, date_start, date_end,
    time_start, time_end, days, period, sites, price, teacher_id
) VALUES (
'Conception et réalisation d''interfaces homme-machine',
'- Comparaison synthétique entre les langages Python et Java
- Introduction à Java
- Codage en Java d''applications simples par l''étudiant-e
- Environnement de développement multiplateforme Eclipse (IDE)
- Présentation des règles d''affichage (Layouts)
- Étude des composants simples et complexes
- Construction d''un code pas à pas avec un window builder
- Étude des modalités d''interaction via souris et clavier
- Présentation des modèles MVC (Modèle-View-Controller) et MVVM
- Implémentation de GUIs interactifs',
'2026-09-10',
'2026-10-01',
'2026-12-20',
'08:30',
'12:00',
'Lundi',
26,
'HE-Arc Neuchâtel',
1200.00,
4
);

INSERT INTO enrollment (user_id, course_id, created_at) VALUES
-- Élève 1 (Marco Dolci)
(1, 1, '2026-03-15'),
(1, 3, '2026-03-15'),
(1, 5, '2026-03-15'),
(1, 7, '2026-03-15'),

-- Élève 2 (Christophe Debons)
(2, 2, '2026-03-20'),
(2, 4, '2026-03-20'),
(2, 6, '2026-03-20'),
(2, 8, '2026-03-20');

INSERT INTO enrollmentstatus (
    id,
    inscription_status,
    admissibilite_status,
    paiement_status,
    realisation_status,
    certification_status
) VALUES
(1, 'green', 'white', 'white', 'white', 'white'),
(2, 'green', 'green', 'white', 'white', 'white'),
(3, 'green', 'green', 'red',   'white', 'white'),
(4, 'green', 'green', 'green', 'white', 'white'),

(5, 'white', 'white', 'white', 'white', 'white'),
(6, 'green', 'white', 'white', 'white', 'white'),
(7, 'green', 'green', 'white', 'white', 'white'),
(8, 'green', 'green', 'green', 'white', 'white');
