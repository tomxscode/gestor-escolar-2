function formatearRut(rut) {
  const rutSinGuion = rut.replace(/\./g, '').replace('-', ''); // Eliminar puntos y guión
  const cuerpo = rutSinGuion.slice(0, -1); // Obtener cuerpo del RUT
  const digitoVerificador = rutSinGuion.slice(-1).toUpperCase(); // Obtener dígito verificador
  const cuerpoFormateado = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Formatear cuerpo con puntos
  return `${cuerpoFormateado}-${digitoVerificador}`; // Devolver RUT formateado
}

function rutToPlainText(rut) {
  // Eliminar puntos y guión
  let rutSinPuntosNiGuion = rut.replace(/\./g,'').replace(/\-/g,'');
  // Extraer dígito verificador
  let dv = rutSinPuntosNiGuion.slice(-1);
  // Extraer número sin dígito verificador
  let num = rutSinPuntosNiGuion.slice(0, -1);
  // Unir número y dígito verificador
  return `${num}-${dv}`;
}