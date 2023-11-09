const shader = {
	vertex: `void main() {
        gl_Position = vec4( position, 1.0 );
    }`,
	fragment: `
    // By Liam Egan
    // 2018
  
    uniform vec2 u_resolution;
    uniform float u_time;
    uniform bool u_complex;
  
    const int octaves = 6;
    const float seed = 43758.5453123;
    const float seed2 = 73156.8473192;
  
  
    vec2 random2(vec2 st, float seed){
        st = vec2( dot(st,vec2(127.1,311.7)),
                  dot(st,vec2(269.5,183.3)) );
        return -1.0 + 2.0*fract(sin(st)*seed);
    }
  
    // Value Noise by Inigo Quilez - iq/2013
    // https://www.shadertoy.com/view/lsf3WH
    float noise(vec2 st, float seed) {
        vec2 i = floor(st);
        vec2 f = fract(st);

        vec2 u = f*f*(3.0-2.0*f);

        return mix( mix( dot( random2(i + vec2(0.0,0.0), seed ), f - vec2(0.0,0.0) ), 
                         dot( random2(i + vec2(1.0,0.0), seed ), f - vec2(1.0,0.0) ), u.x),
                    mix( dot( random2(i + vec2(0.0,1.0), seed ), f - vec2(0.0,1.0) ), 
                         dot( random2(i + vec2(1.0,1.0), seed ), f - vec2(1.0,1.0) ), u.x), u.y);
    }
  
    float fbm1(in vec2 _st, float seed) {
      float v = 0.0;
      float a = 0.5;
      vec2 shift = vec2(100.0);
      // Rotate to reduce axial bias
      mat2 rot = mat2(cos(0.5), sin(0.5),
                      -sin(0.5), cos(0.50));
      for (int i = 0; i < octaves; ++i) {
          v += a * noise(_st, seed);
          _st = rot * _st * 2.0 + shift;
          a *= 0.4;
      }
      return v;
    }
  
    float pattern(vec2 uv, float seed, float time, inout vec2 q, inout vec2 r) {

      q = vec2( fbm1( uv * .1 + vec2(0.0,0.0), seed ),
                     fbm1( uv + vec2(5.2,1.3), seed ) );

      r = vec2( fbm1( uv * .1 + 4.0*q + vec2(1.7 - time / 2.,9.2), seed ),
                     fbm1( uv + 4.0*q + vec2(8.3 - time / 2.,2.8), seed ) );

      vec2 s = vec2( fbm1( uv + 5.0*r + vec2(21.7 - time / 2.,90.2), seed ),
                     fbm1( uv * .05 + 5.0*r + vec2(80.3 - time / 2.,20.8), seed ) );

      return fbm1( uv * .05 + 4.0*s, seed );
    }

    float pattern2(vec2 uv, float seed, float time, inout vec2 q, inout vec2 r) {

      q = vec2( fbm1( uv + vec2(0.0,0.0), seed ),
                     fbm1( uv + vec2(5.2,1.3), seed ) );

      r = vec2( fbm1( uv + 4.0*q + vec2(1.7 - time / 2.,9.2), seed ),
                     fbm1( uv + 4.0*q + vec2(8.3 - time / 2.,2.8), seed ) );

      vec2 s = vec2( fbm1( uv + 5.0*r + vec2(21.7 - time / 2.,90.2), seed ),
                     fbm1( uv + 5.0*r + vec2(80.3 - time / 2.,20.8), seed ) );

      vec2 t = vec2( fbm1( uv + 4.0*s + vec2(121.7 - time / 2.,190.2), seed ),
                     fbm1( uv + 4.0*s + vec2(180.3 - time / 2.,120.8), seed ) );

      vec2 u = vec2( fbm1( uv + 3.0*t + vec2(221.7 - time / 2.,290.2), seed ),
                     fbm1( uv + 3.0*t + vec2(280.3 - time / 2.,220.8), seed ) );

      vec2 v = vec2( fbm1( uv + 2.0*u + vec2(221.7 - time / 2.,290.2), seed ),
                     fbm1( uv + 2.0*u + vec2(280.3 - time / 2.,220.8), seed ) );

      return fbm1( uv + 4.0*v, seed );
    }

    void main() {
      vec2 uv = (gl_FragCoord.xy - 0.5 * u_resolution.xy) / u_resolution.y;
      
      float time = u_time / 10.;
      
      mat2 rot = mat2(cos(time / 10.), sin(time / 10.),
                      -sin(time / 10.), cos(time / 10.));
      
      uv = rot * uv;
      uv *= 0.9 * (sin(u_time / 20.)) + 3.;
      uv.x -= time / 5.;
      
      vec2 q = vec2(0.,0.);
      vec2 r = vec2(0.,0.);
      
      float _pattern = 0.;
      
      if(u_complex) {
        _pattern = pattern2(uv, seed, time, q, r);
      } else {
        _pattern = pattern(uv, seed, time, q, r);
      }
      
      vec3 colour = vec3(_pattern) * 2.;
      colour.r -= dot(q, r) * 15.;
      colour = mix(colour, vec3(pattern(r, seed2, time, q, r), dot(q, r) * 15., -0.1), .5);
      colour -= q.y * 1.5;
      colour = mix(colour, vec3(.2, .2, .2), (clamp(q.x, -1., 0.)) * 3.);
      // colour += clamp(0.4, 0.8, fract(_pattern * 10.)) / 5.;
      
      // gl_FragColor = vec4(abs(colour), 1.);
      gl_FragColor = vec4(-colour + (abs(colour) * .5), 1.);
      // gl_FragColor = vec4(abs(colour), 1.);
    }`
};	
/*
Most of the stuff in here is just bootstrapping. Essentially it's just
setting ThreeJS up so that it renders a flat surface upon which to draw 
the shader. The only thing to see here really is the uniforms sent to 
the shader. Apart from that all of the magic happens in the HTML view
under the fragment shader.
*/

let container;
let camera, scene, renderer;
let uniforms;

function init() {
  container = document.getElementById( 'bg-33' );

  camera = new THREE.Camera();
  camera.position.z = 1;

  scene = new THREE.Scene();

  var geometry = new THREE.PlaneBufferGeometry( 2, 2 );

  uniforms = {
    u_time: { type: "f", value: 2001.0 },
    u_resolution: { type: "v2", value: new THREE.Vector2() },
    u_mouse: { type: "v2", value: new THREE.Vector2() },
    u_complex: { type: "b", value: false }
  };

  var material = new THREE.ShaderMaterial( {
    uniforms: uniforms,
    vertexShader: shader.vertex,
    fragmentShader: shader.fragment
  } );

  var mesh = new THREE.Mesh( geometry, material );
  scene.add( mesh );

  renderer = new THREE.WebGLRenderer();
  // renderer.setPixelRatio( window.devicePixelRatio );

  container.appendChild( renderer.domElement );

  onWindowResize();
  window.addEventListener( 'resize', onWindowResize, false );
  document.onmousemove = function(e){
    uniforms.u_mouse.value.x = e.pageX
    uniforms.u_mouse.value.y = e.pageY
  }
}
function onWindowResize( event ) {
  renderer.setSize( container.offsetWidth, container.offsetHeight );
  uniforms.u_resolution.value.x = renderer.domElement.width;
  uniforms.u_resolution.value.y = renderer.domElement.height;
}
function animate() {
  requestAnimationFrame( animate );
  render();
}

function render() {
  uniforms.u_time.value += 0.05 * (1 + uniforms.u_mouse.value.x / 100000.);
  renderer.render( scene, camera );
}



init();
animate();