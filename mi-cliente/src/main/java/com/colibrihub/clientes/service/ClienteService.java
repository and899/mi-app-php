package com.colibrihub.clientes.service;

import com.colibrihub.clientes.dto.ClienteDto;
import com.colibrihub.clientes.entity.Cliente;

public interface ClienteService {
    ClienteDto crearCliente(ClienteDto dto);
}
