const shader = {
	vertex: `void main() {
	gl_Position = vec4( position, 1.0 );
	}`,
	fragment: `precision highp float;
	uniform vec2 resolution;
	uniform float time;
	uniform vec2 mouse;
	uniform sampler2D backbuffer;
	vec3 wave(vec2 uv,float speed, float thickness, float amplitude, float delay, vec3 color){
	float shake = mix(0.0, 1.0, amplitude);
	float wave = sin(delay + mod(uv.x+uv.y/2.0,0.25) * 1.0 - time * speed ) / 5.0 * shake;
	float colwave = thickness /  abs((1.0-length(uv))+wave); 
	return color * colwave;
	}
	float random (in vec2 st) {
	return fract(cos(dot(st.xy,
	vec2(12.9898,78.233)))
	* 43758.5453123);
	}
	void main(void) {
	vec2 uv = (gl_FragCoord.xy * 2.0 - resolution.xy) / min(resolution.x, resolution.y);
	vec3 col0 = wave(uv,0.1,0.08,8.0,5., vec3(0.6, 0.6, 0.6));
	vec3 col1 = wave(uv,0.2,0.08,9.0,6., vec3(0.4, 0.9, 0.9));
	vec3 col2 = wave(uv,0.2,0.08,10.0,7., vec3(0.6, 0.9, 0.9));
	vec3 col3 = wave(uv,0.1,0.08,11.0,8., vec3(0.6, 0.6, 0.6));
	vec3 col = col0+col1+col2+col3;
	gl_FragColor = vec4(vec3(col), 1.0);
	}`
};	
var container;
var camera, scene, renderer;
var uniforms;
init();
animate();
function init() {
	container = document.getElementById('bg-3');
	camera = new THREE.Camera();
	camera.position.z = 1;
	scene = new THREE.Scene();
	var geometry = new THREE.PlaneBufferGeometry( 2, 2 );
	uniforms = {
		time: { type: "f", value: 1.0 },
		resolution: { type: "v2", value: new THREE.Vector2() }
	};
	var material = new THREE.ShaderMaterial( {
		uniforms: uniforms,
		vertexShader: shader.vertex,
		fragmentShader: shader.fragment
	} );
	var mesh = new THREE.Mesh( geometry, material );
	scene.add( mesh );
	renderer = new THREE.WebGLRenderer();
	renderer.setPixelRatio( window.devicePixelRatio );
	container.appendChild( renderer.domElement );
	onWindowResize();
	window.addEventListener( 'resize', onWindowResize, false );
}
function onWindowResize( event ) {
	renderer.setSize( container.offsetWidth, container.offsetHeight );
	uniforms.resolution.value.x = renderer.domElement.width;
	uniforms.resolution.value.y = renderer.domElement.height;
}
function animate() {
	requestAnimationFrame( animate );
	render();
}
function render() {
	uniforms.time.value += 0.05;
	renderer.render( scene, camera );
}