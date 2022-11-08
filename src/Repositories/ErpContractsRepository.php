<?php

namespace Xguard\BusinessIntelligence\Repositories;

use App\Models\Contract;
use Xguard\BusinessIntelligence\Http\Resources\ContractResource;

class ErpContractsRepository
{
    public static function retrieve(int $erpContractId): ?ContractResource
    {
        $erpContract = Contract::find($erpContractId);
        return $erpContract ? new ContractResource($erpContractId) : null;
    }

    public static function getAllActiveContracts(): array
    {
        $erpContracts = Contract::with('jobSite.subaddresses')
            ->where('status', '=', 'active')
            ->orderBy('contract_identifier')->get();
        return self::formatContracts($erpContracts);
    }

    public static function getSomeActiveContracts($search): array
    {
        $erpContracts = Contract::with('jobSite')
            ->where('status', '=', 'active')
            ->where(function ($q) use ($search) {
                $q->where('contract_identifier', 'like', "%{$search}%");
            })->orderBy('contract_identifier')->take(10)->get();

        return self::formatContracts($erpContracts);
    }

    public static function formatContracts($erpContracts)
    {
        return $erpContracts->map(function ($erpContract) {

            $erpContract->addresses = collect([]);
            $erpContract->addresses->push([
                'id' => $erpContract->jobSite->id,
                'address' => $erpContract->jobSite->google_formatted_address,
                'lat' => $erpContract->jobSite->google_coordinates_lat,
                'lng' => $erpContract->jobSite->google_coordinates_lng,
                'isPrimaryAddress' => true
            ]);
            foreach ($erpContract['jobSite']['subaddresses'] as $subaddress) {
                $erpContract->addresses->push([
                    'id' => $subaddress->id,
                    'address' => $subaddress->formatted_address,
                    'lat' => $subaddress->latitude,
                    'lng' => $subaddress->longitude,
                    'isPrimaryAddress' => false
                ]);
            }

            return [
                'id' => $erpContract->id,
                'name' => $erpContract->contract_identifier,
                'jobSiteImagePath' => $erpContract->job_site_image_path,
                'onSiteClientContactName' => $erpContract->on_site_client_info_contact_name,
                'onSiteClientContactPhone' => $erpContract->on_site_client_info_phone_number,
                'onSiteClientPosition' => $erpContract->on_site_client_info_position,
                'onSiteClientEmail' => $erpContract->on_site_client_info_email,
                'clientNeeds' => $erpContract->client_info_needs,
                'clientType' => $erpContract->client_type,
                'jobSiteType' => $erpContract->job_site_type,
                'workEnvironment' => $erpContract->work_environment,
                'addedXguardServices' => $erpContract->added_xguard_services,
                'accessToEstablishment' => $erpContract->access_to_establishment,
                'typeOfClothing' => $erpContract->type_of_clothing,
                'addresses' => $erpContract->addresses->toArray()
            ];
        })->all();
    }
}
