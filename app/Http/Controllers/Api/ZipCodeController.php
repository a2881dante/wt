<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

use App\Helpers\CsvToDbHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CsvImportRequest;
use App\Repositories\ZipCodeRepository;

class ZipCodeController extends Controller
{
    protected $zipCodesRepo;

    public function __construct(
        ZipCodeRepository $zipCodesRepo
    ){
        $this->zipCodesRepo = $zipCodesRepo;
    }

    /**
     * @OA\Parameter(
     *      parameter="zipCode",
     *      in="path",
     *      name="zipCode",
     *      description="Полный zip-код",
     *      @OA\Schema(
     *          type="string",
     *      )
     * )
     * @OA\Get(
     *     path="/api/zip-code/{zipCode}",
     *     summary="Получить полную информацию про город по zip-коду",
     *     description="Получить полную информацию про город по zip-коду",
     *     operationId="zipCodes",
     *     tags={"ZipApi"},
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Parameter(
     *          ref="#/components/parameters/zipCode",
     *     ),
     * )
     */
    public function getCityByCode($zipCode)
    {
        return response()->json( $this->zipCodesRepo->getByCode($zipCode) );
    }

    /**
     * @OA\Parameter(
     *      parameter="partname",
     *      in="path",
     *      name="partname",
     *      description="Полное или частичное наименования города",
     *      @OA\Schema(
     *          type="string",
     *      )
     * )
     * @OA\Get(
     *     path="/api/cities/{partname}",
     *     summary="Получить список городов по частичному названию",
     *     description="Получить список городов по частичному названию",
     *     operationId="cities",
     *     tags={"ZipApi"},
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Parameter(
     *          ref="#/components/parameters/partname",
     *     ),
     * )
     */
    public function getCitiesByName($partName)
    {
        if(strlen($partName) > 1) {
            return response()->json($this->zipCodesRepo->getByCityPartname($partName));
        } else {
            return response()->json([]);
        }
    }

    /**
     * @OA\RequestBody(
     *   request="CsvFile",
     *   required=true,
     *   description="Файл формата .csv для обновления данных в БД",
     *   @OA\MediaType(
     *     mediaType="multipart/form-data",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="csv_file",
     *           type="file"
     *         )
     *       )
     *   )
     * )
     * @OA\Post(
     *     path="/api/data/update-zips",
     *     summary="Обновление данных из cvs-файла",
     *     description="Обновление данных из cvs-файла",
     *     operationId="updateZips",
     *     tags={"DB"},
     *     @OA\RequestBody(ref="#/components/requestBodies/CsvFile"),
     *     @OA\Response(response="200", description="OK"),
     * )
     */
    public function uploadDbFromFile(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $filename = $file->getClientOriginalName();
        $location = 'uploads';
        $file->move($location, $filename);
        $filepath = $location . "/" . $filename;

        CsvToDbHelper::importCsvToDB($filepath);

        return response()->json([
            'status' => 'success',
        ]);
    }
}
