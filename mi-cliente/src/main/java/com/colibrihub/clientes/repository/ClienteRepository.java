package com.colibrihub.clientes.repository;

import com.colibrihub.clientes.entity.Cliente;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface ClienteRepository extends JpaRepository<Cliente, Long> {
    boolean existsByEmail(String email);
    boolean existsByDui(String dui);
    boolean existsByNit(String nit);
}