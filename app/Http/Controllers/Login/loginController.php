<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Ramsey\Uuid\Uuid;
class loginController extends Controller
{
    public function objeto_a_array($data){
        if (is_array($data) || is_object($data)){
            $result = array();
            foreach ($data as $key => $value){$result[$key] = $this->objeto_a_array($value);}
            return $result;
        }
        return $data;
    }
    public function posLogin(Request $request){
        $dadsad = (isset($request['haders']) && $request['haders'] != "" ? "" . (trim($request['haders'])) . "" : "" );           
        if ($dadsad=="Ox_mSak@t~r}uh_GoerfQly_=EM$4iIYk#v4oFguL)TY2b0~O[") {
            if (is_array($request['datos']) || is_object($request['datos'])){
                $result = array();
                foreach ($request['datos'] as $key => $value){
                    $result[$key] = $this->objeto_a_array($value);
                }
                $result; 
            }
            $Email    = (isset($result['Email']) && $result['Email'] != "" ? "'" . (trim($result['Email'])) . "'" : "");           
            $password    = (isset($result['password']) && $result['password'] != "" ? "'" . (trim($result['password'])) . "'" : "");           
            
            $selects = "SELECT ctu.tNombre AS tipousuario, cu.ecodUsuarios,concat_ws('',cu.tNombre,' ', cu.tApellido) AS usuario, ct.tNombre AS estatus ,cu.ecodTipoUsuario FROM bitcorreos bc
            LEFT JOIN relusuariocorreo ruc ON ruc.ecodCorreo = bc.ecodCorreo
            LEFT JOIN catusuarios cu ON cu.ecodUsuarios = ruc.ecodUsuario
            LEFT JOIN catestatus ct ON ct.EcodEstatus = cu.EcodEstatus
            LEFT JOIN cattipousuario ctu ON ctu.ecotTipoUsuario= cu.ecodTipoUsuario
            WHERE bc.tcorreo = ".$Email."  
            AND bc.tpassword = ".$password."
            AND cu.EcodEstatus = 1";
            $sql = DB::select(DB::raw($selects));
            foreach ($sql as $key => $v){
                $logindata[]=array(
                    'ecodUsuarios' => $v->ecodUsuarios,
                    'usuario'=> $v->usuario, 
                    'tipousuario'=>$v->tipousuario,  
                );
            }
            return response()->json(['sql'=>(isset($logindata) ? $logindata : ""),]);
        }
    }
    
    public function poscontras(Request $request)
    {
    $dadsad = (isset($request['haders']) && $request['haders'] != "" ? "" . (trim($request['haders'])) . "" : "" );           
    if ($dadsad=="Ox_mSak@t~r}uh_GoerfQly_=EM$4iIYk#v4oFguL)TY2b0~O[") {
        if (is_array($request['datos']) || is_object($request['datos'])){
            $result = array();
            foreach ($request['datos'] as $key => $value){
                $result[$key] = $this->objeto_a_array($value);
            }
        }
        $ecodUsuario    = (isset($result['loginEcodUsuarios']) && $result['loginEcodUsuarios'] != "" ? "'" . (trim($result['loginEcodUsuarios'])) . "'" : "");           
        $password    = (isset($result['contrasena']) && $result['contrasena'] != "" ? "'" . (trim($result['contrasena'])) . "'" : "");           
        $selectcontra="SELECT count(*) AS dl FROM relusuariocorreo ruc
        LEFT JOIN bitcorreos bc ON bc.ecodCorreo = ruc.ecodCorreo
        WHERE ruc.ecodUsuario =".$ecodUsuario."
        AND bc.tpassword =".$password;
        $sqlcontra = DB::select(DB::raw($selectcontra));
        return response()->json(['sql'=>$sqlcontra[0]]);
        }
    }
    public function geta(Request $request){
        return response()->json(($sql));
    }
    
    public function posRegistro(Request $request){ 
        $datass = (isset($request['haders']) && $request['haders'] != "" ? "" . (trim($request['haders'])) . "" : "" );           
        if ($datass=="Ox_mSak@t~r}uh_GoerfQly_=EM$4iIYk#v4oFguL)TY2b0~O[") {
            DB::beginTransaction();
            try {
            if (is_array($request['datos']) || is_object($request['datos'])){
                $result = array();
                foreach ($request['datos'] as $key => $value){
                    $result[$key] = $this->objeto_a_array($value);
                }
                $result; 
            }
            $exito = 1;
            $uuid = Uuid::uuid4();
            $uuid2 = (isset($uuid)&&$uuid!="" ? "'".(trim($uuid))."'":   "NULL");
            $tNombre = (isset($result['tNombre'])&&$result['tNombre']!="" ? "'".(trim($result['tNombre']))."'":   "NULL");
            $tApellido = (isset($result['tApellido'])&&$result['tApellido']!="" ? "'".(trim($result['tApellido']))."'":   "NULL");
            $fhNacimiento = (isset($result['fhNacimiento'])&&$result['fhNacimiento']!="" ? "'".(trim($result['fhNacimiento']))."'":   "NULL");
            $Email    = (isset($result['Email']) && $result['Email'] != "" ? "'" . (trim($result['Email'])) . "'" : "");           
            $password    = (isset($result['password']) && $result['password'] != "" ? "'" . (trim($result['password'])) . "'" : "");  
            $EcodEstatus = 1;

            $insert=" CALL `stpInsertarUsuarioLogin`(".$fhNacimiento.",".$tNombre.",".$tApellido.",".$EcodEstatus.",".$uuid2.",".$Email.",".$password.")";
            $response = DB::select($insert);

            $insertMails =" CALL `stpInsertarBitCorreoLogin`(".$Email.",".$password.")";
            $responseincerMails = DB::select($insertMails);

            $codigoCoreeo = (isset($responseincerMails[0]->Codigo)&& $responseincerMails[0]->Codigo>0  ? (int)$responseincerMails[0]->Codigo : "NULL");
           
            $incerrelucerCorreo=" CALL `stpInsertarRelusUarioCorreo`(".$uuid2.",".$codigoCoreeo.")";
            $responsincerrelucerCorreo = DB::select($incerrelucerCorreo);
            $codigoRelCoreeo = (isset($responsincerrelucerCorreo[0]->Codigo)&& $responsincerrelucerCorreo[0]->Codigo>0  ? (int)$responsincerrelucerCorreo[0]->Codigo : "NULL"); 
            
            if (!$codigoRelCoreeo) {
                $exito = 0;
            }
            
          
            if ($exito == 0) {
                DB::rollback();
            } else {
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollback();
            $exito = $e->getMessage();
        }
         return response()->json(['exito' => $exito]);
        }
    }
}
