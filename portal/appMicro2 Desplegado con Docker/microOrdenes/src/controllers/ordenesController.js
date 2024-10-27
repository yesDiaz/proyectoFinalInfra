const express = require('express');
const router = express.Router();
const axios = require('axios');
const ordenesModel = require('../models/ordenesModel');


router.get('/ordenes/:id', async (req, res) => {
    const id = req.params.id;
    var result;
    result = await ordenesModel.traerOrden(id) ;
    res.json(result[0]);
});


router.get('/ordenes', async (req, res) => {
    var result;
    result = await ordenesModel.traerOrdenes() ;
    res.json(result);
});


router.post('/ordenes', async (req, res) => {
    const usuario = req.body.usuario;
    const items = req.body.items;

    // Validar que el usuario exista
    const responseUsuario = await axios.get(`http://microusuarios:3001/usuarios/${usuario}`);
    if (!responseUsuario.data) {
        return res.status(404).json({ error: 'Usuario no encontrado' });
    }

    // Validar que los productos existan
    for (const producto of items) {
        const responseProducto = await axios.get(`http://microproductos:3002/productos/${producto.id}`);
        if (!responseProducto.data) {
            return res.status(404).json({ error: `Producto con ID ${producto.id} no encontrado` });
        }
    }

    // Calcular el total de la cuenta
    const totalCuenta = await calcularTotal(items);

    // Si el total es 0 o negativo, retornamos un error
    if (totalCuenta <= 0) {
        return res.json({ error: 'Invalid order total' });
    }

    // Verificamos si hay suficientes unidades de los productos para realizar la orden
    const disponibilidad = await verificarDisponibilidad(items);

    // Si no hay suficientes unidades de los productos, retornamos un error
    if (!disponibilidad) {
        return res.json({ error: 'No hay disponibilidad de productos' });
    }

    // Creamos la orden
    const name = responseUsuario.data.nombre;
    const email = responseUsuario.data.email;
    const orden = { nombreCliente: name, emailCliente: email, totalCuenta };
    const ordenRes = await ordenesModel.crearOrden(orden);

    // Disminuimos la cantidad de unidades de los productos
    await actualizarInventario(items);

    return res.send("orden creada");
});



// Función para calcular el total de la orden
async function calcularTotal(items) {
    let ordenTotal = 0;
    for (const producto of items) {
        const response = await axios.get(`http://microproductos:3002/productos/${producto.id}`);
        ordenTotal += response.data.precio * producto.cantidad;
    }
    return ordenTotal;
}


// Función para verificar si hay suficientes unidades de los productos para realizar la orden
async function verificarDisponibilidad(items) {
    let disponibilidad = true;
    for (const producto of items) {
        const response = await axios.get(`http://microproductos:3002/productos/${producto.id}`);
        if (response.data.inventario < producto.cantidad) {
            disponibilidad = false;
            break;
        }
    }
    return disponibilidad;
}


// Función para disminuir la cantidad de unidades de los productos
async function actualizarInventario(items) {
    for (const producto of items) {
        const response = await axios.get(`http://microproductos:3002/productos/${producto.id}`);
        const inventarioActual = response.data.inventario;
        const inv=inventarioActual - producto.cantidad;
        await axios.put(`http://microproductos:3002/productos/${producto.id}`, {
           inventario: inv
        });
    }
}

module.exports = router;