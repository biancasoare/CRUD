CREATE TABLE clienti (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nume` VARCHAR(20) NOT NULL,
  `prenume` VARCHAR(20) NOT NULL,
  `email` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email` (`email` ASC))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8


CREATE TABLE produse (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `denumire` VARCHAR(20) NOT NULL,
  `pret_fara_tva` DECIMAL(18,0) NOT NULL,
  `cota_tva` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `denumire` (`denumire` ASC))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


CREATE TABLE comenzi (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `comanda` VARCHAR(20) NOT NULL,
  `produse_id` INT(10) UNSIGNED NOT NULL,
  `clienti_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `produse_id`, `clienti_id`),
  INDEX `fk_comenzi_produse_idx` (`produse_id` ASC),
  INDEX `fk_comenzi_clienti1_idx` (`clienti_id` ASC),
  CONSTRAINT `fk_comenzi_produse`
  FOREIGN KEY (`produse_id`)
  REFERENCES `dbname`.`produse` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comenzi_clienti1`
  FOREIGN KEY (`clienti_id`)
  REFERENCES `dbname`.`clienti` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;


INSERT INTO produse (denumire, pret_fara_tva, cota_tva) VALUES ('carte', 100, 3);
INSERT INTO produse (denumire, pret_fara_tva, cota_tva) VALUES ('caiet', 50, 3);
INSERT INTO produse (denumire, pret_fara_tva, cota_tva) VALUES ('stilou', 40, 3);
INSERT INTO produse (denumire, pret_fara_tva, cota_tva) VALUES ('ghiozdan', 300, 3);
INSERT INTO produse (denumire, pret_fara_tva, cota_tva) VALUES ('tricou', 150, 3);


SELECT * FROM clienti c LEFT JOIN comenzi co ON c.id = co.clienti_id
LEFT JOIN produse p ON co.produse_id = p.id ORDER BY clienti_id ASC;