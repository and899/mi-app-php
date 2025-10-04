package com.colibrihub.clientes.entity;


import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDate;
import java.time.LocalDateTime;

@AllArgsConstructor
@NoArgsConstructor
@Data
@Entity
@Table(name = "cliente")
public class Cliente {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(nullable = false, length = 100)
    private String nombre;

    @Column(nullable = false, length = 100)
    private String apellido;

    @Column(nullable = false, unique = true, length = 120)
    private String email;

    @Column(length = 15, unique = true)
    private String telefono;

    @Column(length = 200)
    private String direccion;

    @Column(length = 50, unique = true)
    private String dui; // Documento único de identidad

    @Column(length = 50, unique = true)
    private String nit; // Número de identificación tributaria

    @Column(nullable = false)
    private LocalDate fechaRegistro;

    @Column(nullable = false)
    private Boolean activo;

    @Column(length = 20)
    private String genero; // Masculino, Femenino, Otro

    @Column(length = 20)
    private String estadoCivil; // Soltero, Casado, etc.

    @Column(length = 100)
    private String ocupacion;

    @Column(length = 255)
    private String observaciones;

}
