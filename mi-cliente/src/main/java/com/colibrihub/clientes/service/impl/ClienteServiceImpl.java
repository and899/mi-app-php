package com.colibrihub.clientes.service.impl;

import com.colibrihub.clientes.dto.ClienteDto;
import com.colibrihub.clientes.entity.Cliente;
import com.colibrihub.clientes.mapper.ClienteMapper;
import com.colibrihub.clientes.repository.ClienteRepository;
import com.colibrihub.clientes.service.ClienteService;
import org.springframework.stereotype.Service;
import org.springframework.http.MediaType;
import org.springframework.web.reactive.function.client.WebClient;

import java.time.LocalDate;

@Service
public class ClienteServiceImpl implements ClienteService {

    private final ClienteRepository clienteRepository;
    private final WebClient webClient;

    public ClienteServiceImpl(ClienteRepository clienteRepository,  WebClient webClient) {
        this.clienteRepository = clienteRepository;
        this.webClient = webClient;
    }

    @Override
    public ClienteDto crearCliente(ClienteDto dto) {
        // Validaciones
        if (clienteRepository.existsByEmail(dto.getEmail())) {
            throw new RuntimeException("El email ya está registrado");
        }
        if (dto.getDui() != null && clienteRepository.existsByDui(dto.getDui())) {
            throw new RuntimeException("El DUI ya está registrado");
        }
        if (dto.getNit() != null && clienteRepository.existsByNit(dto.getNit())) {
            throw new RuntimeException("El NIT ya está registrado");
        }

        // MapStruct hace el mapeo DTO → Entity
        Cliente cliente = ClienteMapper.toEntity(dto);
        cliente.setFechaRegistro(LocalDate.now());
        cliente.setActivo(true);

        Cliente clienteGuardado = clienteRepository.save(cliente);

        // Mapear a DTO
        ClienteDto clienteDtoGuardado = ClienteMapper.toDto(clienteGuardado);

        // Enviar a otra URL
        enviarClienteExterno(clienteDtoGuardado);

        return clienteDtoGuardado;
    }

    private void enviarClienteExterno(ClienteDto dto) {
        webClient.post()
                .uri("http://62.171.169.111:8091/api/clientes/notification") // Cambia esta URL
                .contentType(MediaType.APPLICATION_JSON)
                .bodyValue(dto)
                .retrieve()
                .bodyToMono(Void.class) // si no esperamos respuesta
                .subscribe(
                        unused -> System.out.println("DTO enviado correctamente"),
                        error -> System.err.println("Error al enviar DTO: " + error.getMessage())
                );
    }
}
