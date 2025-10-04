package com.colibrihub.clientes.mapper;

import com.colibrihub.clientes.dto.ClienteDto;
import com.colibrihub.clientes.entity.Cliente;


public class ClienteMapper {
    // Convierte de DTO a Entity
    public static Cliente toEntity(ClienteDto dto) {
        Cliente cliente = new Cliente();
        cliente.setNombre(dto.getNombre());
        cliente.setApellido(dto.getApellido());
        cliente.setEmail(dto.getEmail());
        cliente.setTelefono(dto.getTelefono());
        cliente.setDireccion(dto.getDireccion());
        cliente.setDui(dto.getDui());
        cliente.setNit(dto.getNit());
        cliente.setGenero(dto.getGenero());
        cliente.setEstadoCivil(dto.getEstadoCivil());
        cliente.setOcupacion(dto.getOcupacion());
        cliente.setObservaciones(dto.getObservaciones());
        return cliente;
    }

    // Convierte de Entity a DTO
    public static ClienteDto toDto(Cliente cliente) {
        ClienteDto dto = new ClienteDto();
        dto.setNombre(cliente.getNombre());
        dto.setApellido(cliente.getApellido());
        dto.setEmail(cliente.getEmail());
        dto.setTelefono(cliente.getTelefono());
        dto.setDireccion(cliente.getDireccion());
        dto.setDui(cliente.getDui());
        dto.setNit(cliente.getNit());
        dto.setGenero(cliente.getGenero());
        dto.setEstadoCivil(cliente.getEstadoCivil());
        dto.setOcupacion(cliente.getOcupacion());
        dto.setObservaciones(cliente.getObservaciones());
        return dto;
    }
}
