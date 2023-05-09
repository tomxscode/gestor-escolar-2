function formatearRut(rut) {
  const rutSinGuion = rut.replace(/\./g, '').replace('-', ''); // Eliminar puntos y guión
  const cuerpo = rutSinGuion.slice(0, -1); // Obtener cuerpo del RUT
  const digitoVerificador = rutSinGuion.slice(-1).toUpperCase(); // Obtener dígito verificador
  const cuerpoFormateado = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Formatear cuerpo con puntos
  return `${cuerpoFormateado}-${digitoVerificador}`; // Devolver RUT formateado
}