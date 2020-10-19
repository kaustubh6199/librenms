<?php
/**
 * Ironware.php
 *
 * Brocade Ironware OS
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link       http://librenms.org
 * @copyright  2018 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\OS;

use App\Models\Device;
use LibreNMS\OS\Shared\Foundry;

class Ironware extends Foundry
{
    public function discoverOS(Device $device): void
    {
        parent::discoverOS($device); // yaml

        $this->rewriteHardware();
    }

    private function rewriteHardware()
    {
        $rewrite_ironware_hardware = [
            'snFIWGSwitch' => 'Stackable FastIron workgroup',
            'snFIBBSwitch' => 'Stackable FastIron backbone',
            'snNIRouter' => 'Stackable NetIron',
            'snSI' => 'Stackable ServerIron',
            'snSIXL' => 'Stackable ServerIronXL',
            'snSIXLTCS' => 'Stackable ServerIronXL TCS',
            'snTISwitch' => 'Stackable TurboIron',
            'snTIRouter' => 'Stackable TurboIron',
            'snT8Switch' => 'Stackable TurboIron 8',
            'snT8Router' => 'Stackable TurboIron 8',
            'snT8SIXLG' => 'Stackable ServerIronXLG',
            'snBI4000Switch' => 'BigIron 4000',
            'snBI4000Router' => 'BigIron 4000',
            'snBI4000SI' => 'BigServerIron',
            'snBI8000Switch' => 'BigIron 8000',
            'snBI8000Router' => 'BigIron 8000',
            'snBI8000SI' => 'BigServerIron',
            'snFI2Switch' => 'FastIron II',
            'snFI2Router' => 'FastIron II',
            'snFI2PlusSwitch' => 'FastIron II Plus',
            'snFI2PlusRouter' => 'FastIron II Plus',
            'snNI400Router' => 'NetIron 400',
            'snNI800Router' => 'NetIron 800',
            'snFI2GCSwitch' => 'FastIron II GC',
            'snFI2GCRouter' => 'FastIron II GC',
            'snFI2PlusGCSwitch' => 'FastIron II Plus GC',
            'snFI2PlusGCRouter' => 'FastIron II Plus GC',
            'snBI15000Switch' => 'BigIron 15000',
            'snBI15000Router' => 'BigIron 15000',
            'snNI1500Router' => 'NetIron 1500',
            'snFI3Switch' => 'FastIron III',
            'snFI3Router' => 'FastIron III',
            'snFI3GCSwitch' => 'FastIron III GC',
            'snFI3GCRouter' => 'FastIron III GC',
            'snSI400Switch' => 'ServerIron 400',
            'snSI400Router' => 'ServerIron 400',
            'snSI800Switch' => 'ServerIron800',
            'snSI800Router' => 'ServerIron800',
            'snSI1500Switch' => 'ServerIron1500',
            'snSI1500Router' => 'ServerIron1500',
            'sn4802Switch' => 'Stackable 4802',
            'sn4802Router' => 'Stackable 4802',
            'sn4802SI' => 'Stackable 4802 ServerIron',
            'snFI400Switch' => 'FastIron 400',
            'snFI400Router' => 'FastIron 400',
            'snFI800Switch' => 'FastIron800',
            'snFI800Router' => 'FastIron800',
            'snFI1500Switch' => 'FastIron1500',
            'snFI1500Router' => 'FastIron1500',
            'snFES2402' => 'FES 2402',
            'snFES2402Switch' => 'FES2402',
            'snFES2402Router' => 'FES2402',
            'snFES4802' => 'FES 4802',
            'snFES4802Switch' => 'FES4802',
            'snFES4802Router' => 'FES4802',
            'snFES9604' => 'FES 9604',
            'snFES9604Switch' => 'FES9604',
            'snFES9604Router' => 'FES9604',
            'snFES12GCF' => 'FES 12GCF',
            'snFES12GCFSwitch' => 'FES12GCF',
            'snFES12GCFRouter' => 'FES12GCF',
            'snFES2402POE' => 'FES 2402 POE',
            'snFES2402POESwitch' => 'FES 2402 POE',
            'snFES2402POERouter' => 'FES 2402 POE',
            'snFES4802POE' => 'FES 4802 POE',
            'snFES4802POESwitch' => 'FES 4802 POE',
            'snFES4802POERouter' => 'FES 4802 POE',
            'snNI4802Switch' => 'NetIron 4802',
            'snNI4802Router' => 'NetIron 4802',
            'snBIMG8Switch' => 'BigIron MG8',
            'snBIMG8Router' => 'BigIron MG8',
            'snNI40GRouter' => 'NetIron 40G',
            'snFESX424Switch' => 'FESX424',
            'snFESX424Router' => 'FESX424',
            'snFESX424PremSwitch' => 'FESX424-PREM',
            'snFESX424PremRouter' => 'FESX424-PREM',
            'snFESX424Plus1XGSwitch' => 'FESX424+1XG',
            'snFESX424Plus1XGRouter' => 'FESX424+1XG',
            'snFESX424Plus1XGPremSwitch' => 'FESX424+1XG-PREM',
            'snFESX424Plus1XGPremRouter' => 'FESX424+1XG-PREM',
            'snFESX424Plus2XGSwitch' => 'FESX424+2XG',
            'snFESX424Plus2XGRouter' => 'FESX424+2XG',
            'snFESX424Plus2XGPremSwitch' => 'FESX424+2XG-PREM',
            'snFESX424Plus2XGPremRouter' => 'FESX424+2XG-PREM',
            'snFESX448Switch' => 'FESX448',
            'snFESX448Router' => 'FESX448',
            'snFESX448PremSwitch' => 'FESX448-PREM',
            'snFESX448PremRouter' => 'FESX448-PREM',
            'snFESX448Plus1XGSwitch' => 'FESX448+1XG',
            'snFESX448Plus1XGRouter' => 'FESX448+1XG',
            'snFESX448Plus1XGPremSwitch' => 'FESX448+1XG-PREM',
            'snFESX448Plus1XGPremRouter' => 'FESX448+1XG-PREM',
            'snFESX448Plus2XGSwitch' => 'FESX448+2XG',
            'snFESX448Plus2XGRouter' => 'FESX448+2XG',
            'snFESX448Plus2XGPremSwitch' => 'FESX448+2XG-PREM',
            'snFESX448Plus2XGPremRouter' => 'FESX448+2XG-PREM',
            'snFESX424FiberSwitch' => 'FESX424Fiber',
            'snFESX424FiberRouter' => 'FESX424Fiber',
            'snFESX424FiberPremSwitch' => 'FESX424Fiber-PREM',
            'snFESX424FiberPremRouter' => 'FESX424Fiber-PREM',
            'snFESX424FiberPlus1XGSwitch' => 'FESX424Fiber+1XG',
            'snFESX424FiberPlus1XGRouter' => 'FESX424Fiber+1XG',
            'snFESX424FiberPlus1XGPremSwitch' => 'FESX424Fiber+1XG-PREM',
            'snFESX424FiberPlus1XGPremRouter' => 'FESX424Fiber+1XG-PREM',
            'snFESX424FiberPlus2XGSwitch' => 'FESX424Fiber+2XG',
            'snFESX424FiberPlus2XGRouter' => 'FESX424Fiber+2XG',
            'snFESX424FiberPlus2XGPremSwitch' => 'FESX424Fiber+2XG-PREM',
            'snFESX424FiberPlus2XGPremRouter' => 'FESX424Fiber+2XG-PREM',
            'snFESX448FiberSwitch' => 'FESX448Fiber',
            'snFESX448FiberRouter' => 'FESX448Fiber',
            'snFESX448FiberPremSwitch' => 'FESX448Fiber-PREM',
            'snFESX448FiberPremRouter' => 'FESX448Fiber-PREM',
            'snFESX448FiberPlus1XGSwitch' => 'FESX448Fiber+1XG',
            'snFESX448FiberPlus1XGRouter' => 'FESX448Fiber+1XG',
            'snFESX448FiberPlus1XGPremSwitch' => 'FESX448Fiber+1XG-PREM',
            'snFESX448FiberPlus1XGPremRouter' => 'FESX448Fiber+1XG-PREM',
            'snFESX448FiberPlus2XGSwitch' => 'FESX448Fiber+2XG',
            'snFESX448FiberPlus2XGRouter' => 'FESX448+2XG',
            'snFESX448FiberPlus2XGPremSwitch' => 'FESX448Fiber+2XG-PREM',
            'snFESX448FiberPlus2XGPremRouter' => 'FESX448Fiber+2XG-PREM',
            'snFESX424POESwitch' => 'FESX424POE',
            'snFESX424POERouter' => 'FESX424POE',
            'snFESX424POEPremSwitch' => 'FESX424POE-PREM',
            'snFESX424POEPremRouter' => 'FESX424POE-PREM',
            'snFESX424POEPlus1XGSwitch' => 'FESX424POE+1XG',
            'snFESX424POEPlus1XGRouter' => 'FESX424POE+1XG',
            'snFESX424POEPlus1XGPremSwitch' => 'FESX424POE+1XG-PREM',
            'snFESX424POEPlus1XGPremRouter' => 'FESX424POE+1XG-PREM',
            'snFESX424POEPlus2XGSwitch' => 'FESX424POE+2XG',
            'snFESX424POEPlus2XGRouter' => 'FESX424POE+2XG',
            'snFESX424POEPlus2XGPremSwitch' => 'FESX424POE+2XG-PREM',
            'snFESX424POEPlus2XGPremRouter' => 'FESX424POE+2XG-PREM',
            'snFESX624Switch' => 'FESX624',
            'snFESX624Router' => 'FESX624 Ipv4',
            'snFESX624PremSwitch' => 'FESX624-PREM',
            'snFESX624PremRouter' => 'FESX624-PREM Ipv4',
            'snFESX624Prem6Router' => 'FESX624-PREM Ipv6',
            'snFESX624Plus1XGSwitch' => 'FESX624+1XG',
            'snFESX624Plus1XGRouter' => 'FESX624+1XG Ipv4',
            'snFESX624Plus1XGPremSwitch' => 'FESX624+1XG-PREM',
            'snFESX624Plus1XGPremRouter' => 'FESX624+1XG-PREM Ipv4',
            'snFESX624Plus1XGPrem6Router' => 'FESX624+1XG-PREM Ipv6',
            'snFESX624Plus2XGSwitch' => 'FESX624+2XG',
            'snFESX624Plus2XGRouter' => 'FESX624+2XG Ipv4',
            'snFESX624Plus2XGPremSwitch' => 'FESX624+2XG-PREM',
            'snFESX624Plus2XGPremRouter' => 'FESX624+2XG-PREM Ipv4',
            'snFESX624Plus2XGPrem6Router' => 'FESX624+2XG-PREM Ipv6',
            'snFESX648Switch' => 'FESX648',
            'snFESX648Router' => 'FESX648 Ipv4',
            'snFESX648PremSwitch' => 'FESX648-PREM',
            'snFESX648PremRouter' => 'FESX648-PREM Ipv4',
            'snFESX648Prem6Router' => 'FESX648-PREM Ipv6',
            'snFESX648Plus1XGSwitch' => 'FESX648+1XG',
            'snFESX648Plus1XGRouter' => 'FESX648+1XG Ipv4',
            'snFESX648Plus1XGPremSwitch' => 'FESX648+1XG-PREM',
            'snFESX648Plus1XGPremRouter' => 'FESX648+1XG-PREM Ipv4',
            'snFESX648Plus1XGPrem6Router' => 'FESX648+1XG-PREM Ipv6',
            'snFESX648Plus2XGSwitch' => 'FESX648+2XG',
            'snFESX648Plus2XGRouter' => 'FESX648+2XG Ipv4',
            'snFESX648Plus2XGPremSwitch' => 'FESX648+2XG-PREM',
            'snFESX648Plus2XGPremRouter' => 'FESX648+2XG-PREM Ipv4',
            'snFESX648Plus2XGPrem6Router' => 'FESX648+2XG-PREM Ipv6',
            'snFESX624FiberSwitch' => 'FESX624Fiber',
            'snFESX624FiberRouter' => 'FESX624Fiber Ipv4',
            'snFESX624FiberPremSwitch' => 'FESX624Fiber-PREM',
            'snFESX624FiberPremRouter' => 'FESX624Fiber-PREM Ipv4',
            'snFESX624FiberPrem6Router' => 'FESX624Fiber-PREM Ipv6',
            'snFESX624FiberPlus1XGSwitch' => 'FESX624Fiber+1XG',
            'snFESX624FiberPlus1XGRouter' => 'FESX624Fiber+1XG Ipv4',
            'snFESX624FiberPlus1XGPremSwitch' => 'FESX624Fiber+1XG-PREM',
            'snFESX624FiberPlus1XGPremRouter' => 'FESX624Fiber+1XG-PREM Ipv4',
            'snFESX624FiberPlus1XGPrem6Router' => 'FESX624Fiber+1XG-PREM Ipv6',
            'snFESX624FiberPlus2XGSwitch' => 'FESX624Fiber+2XG',
            'snFESX624FiberPlus2XGRouter' => 'FESX624Fiber+2XG Ipv4',
            'snFESX624FiberPlus2XGPremSwitch' => 'FESX624Fiber+2XG-PREM',
            'snFESX624FiberPlus2XGPremRouter' => 'FESX624Fiber+2XG-PREM Ipv4',
            'snFESX624FiberPlus2XGPrem6Router' => 'FESX624Fiber+2XG-PREM Ipv6',
            'snFESX648FiberSwitch' => 'FESX648Fiber',
            'snFESX648FiberRouter' => 'FESX648Fiber Ipv4',
            'snFESX648FiberPremSwitch' => 'FESX648Fiber-PREM',
            'snFESX648FiberPremRouter' => 'FESX648Fiber-PREM Ipv4',
            'snFESX648FiberPrem6Router' => 'FESX648Fiber-PREM Ipv6',
            'snFESX648FiberPlus1XGSwitch' => 'FESX648Fiber+1XG',
            'snFESX648FiberPlus1XGRouter' => 'FESX648Fiber+1XG Ipv4',
            'snFESX648FiberPlus1XGPremSwitch' => 'FESX648Fiber+1XG-PREM',
            'snFESX648FiberPlus1XGPremRouter' => 'FESX648Fiber+1XG-PREM Ipv4',
            'snFESX648FiberPlus1XGPrem6Router' => 'FESX648Fiber+1XG-PREM Ipv6',
            'snFESX648FiberPlus2XGSwitch' => 'FESX648Fiber+2XG',
            'snFESX648FiberPlus2XGRouter' => 'FESX648+2XG Ipv4',
            'snFESX648FiberPlus2XGPremSwitch' => 'FESX648Fiber+2XG-PREM',
            'snFESX648FiberPlus2XGPremRouter' => 'FESX648Fiber+2XG-PREM Ipv4',
            'snFESX648FiberPlus2XGPrem6Router' => 'FESX648Fiber+2XG-PREM Ipv6',
            'snFESX624POESwitch' => 'FESX624POE',
            'snFESX624POERouter' => 'FESX624POE Ipv4',
            'snFESX624POEPremSwitch' => 'FESX624POE-PREM',
            'snFESX624POEPremRouter' => 'FESX624POE-PREM Ipv4',
            'snFESX624POEPrem6Router' => 'FESX624POE-PREM Ipv6',
            'snFESX624POEPlus1XGSwitch' => 'FESX624POE+1XG',
            'snFESX624POEPlus1XGRouter' => 'FESX624POE+1XG Ipv4',
            'snFESX624POEPlus1XGPremSwitch' => 'FESX624POE+1XG-PREM',
            'snFESX624POEPlus1XGPremRouter' => 'FESX624POE+1XG-PREM Ipv4',
            'snFESX624POEPlus1XGPrem6Router' => 'FESX624POE+1XG-PREM Ipv6',
            'snFESX624POEPlus2XGSwitch' => 'FESX624POE+2XG',
            'snFESX624POEPlus2XGRouter' => 'FESX624POE+2XG Ipv4',
            'snFESX624POEPlus2XGPremSwitch' => 'FESX624POE+2XG-PREM',
            'snFESX624POEPlus2XGPremRouter' => 'FESX624POE+2XG-PREM Ipv4',
            'snFESX624POEPlus2XGPrem6Router' => 'FESX624POE+2XG-PREM Ipv6',
            'snFESX624ESwitch' => 'FESX624',
            'snFESX624ERouter' => 'FESX624 Ipv4',
            'snFESX624EPremSwitch' => 'FESX624-PREM',
            'snFESX624EPremRouter' => 'FESX624-PREM Ipv4',
            'snFESX624EPrem6Router' => 'FESX624-PREM Ipv6',
            'snFESX624EPlus1XGSwitch' => 'FESX624+1XG',
            'snFESX624EPlus1XGRouter' => 'FESX624+1XG Ipv4',
            'snFESX624EPlus1XGPremSwitch' => 'FESX624+1XG-PREM',
            'snFESX624EPlus1XGPremRouter' => 'FESX624+1XG-PREM Ipv4',
            'snFESX624EPlus1XGPrem6Router' => 'FESX624+1XG-PREM Ipv6',
            'snFESX624EPlus2XGSwitch' => 'FESX624+2XG',
            'snFESX624EPlus2XGRouter' => 'FESX624+2XG Ipv4',
            'snFESX624EPlus2XGPremSwitch' => 'FESX624+2XG-PREM',
            'snFESX624EPlus2XGPremRouter' => 'FESX624+2XG-PREM Ipv4',
            'snFESX624EPlus2XGPrem6Router' => 'FESX624+2XG-PREM Ipv6',
            'snFESX624EFiberSwitch' => 'FESX624Fiber',
            'snFESX624EFiberRouter' => 'FESX624Fiber Ipv4',
            'snFESX624EFiberPremSwitch' => 'FESX624Fiber-PREM',
            'snFESX624EFiberPremRouter' => 'FESX624Fiber-PREM Ipv4',
            'snFESX624EFiberPrem6Router' => 'FESX624Fiber-PREM Ipv6',
            'snFESX624EFiberPlus1XGSwitch' => 'FESX624Fiber+1XG',
            'snFESX624EFiberPlus1XGRouter' => 'FESX624Fiber+1XG Ipv4',
            'snFESX624EFiberPlus1XGPremSwitch' => 'FESX624Fiber+1XG-PREM',
            'snFESX624EFiberPlus1XGPremRouter' => 'FESX624Fiber+1XG-PREM Ipv4',
            'snFESX624EFiberPlus1XGPrem6Router' => 'FESX624Fiber+1XG-PREM Ipv6',
            'snFESX624EFiberPlus2XGSwitch' => 'FESX624Fiber+2XG',
            'snFESX624EFiberPlus2XGRouter' => 'FESX624Fiber+2XG Ipv4',
            'snFESX624EFiberPlus2XGPremSwitch' => 'FESX624Fiber+2XG-PREM',
            'snFESX624EFiberPlus2XGPremRouter' => 'FESX624Fiber+2XG-PREM Ipv4 ',
            'snFESX624EFiberPlus2XGPrem6Router' => 'FESX624Fiber+2XG-PREM Ipv6',
            'snFESX648ESwitch' => 'FESX648',
            'snFESX648ERouter' => 'FESX648 Ipv4',
            'snFESX648EPremSwitch' => 'FESX648-PREM',
            'snFESX648EPremRouter' => 'FESX648-PREM Ipv4',
            'snFESX648EPrem6Router' => 'FESX648-PREM Ipv6',
            'snFESX648EPlus1XGSwitch' => 'FESX648+1XG',
            'snFESX648EPlus1XGRouter' => 'FESX648+1XG Ipv4',
            'snFESX648EPlus1XGPremSwitch' => 'FESX648+1XG-PREM',
            'snFESX648EPlus1XGPremRouter' => 'FESX648+1XG-PREM Ipv4',
            'snFESX648EPlus1XGPrem6Router' => 'FESX648+1XG-PREM Ipv6',
            'snFESX648EPlus2XGSwitch' => 'FESX648+2XG',
            'snFESX648EPlus2XGRouter' => 'FESX648+2XG Ipv4',
            'snFESX648EPlus2XGPremSwitch' => 'FESX648+2XG-PREM',
            'snFESX648EPlus2XGPremRouter' => 'FESX648+2XG-PREM Ipv4',
            'snFESX648EPlus2XGPrem6Router' => 'FESX648+2XG-PREM Ipv6',
            'snFWSX424Switch' => 'FWSX424',
            'snFWSX424Router' => 'FWSX424',
            'snFWSX424Plus1XGSwitch' => 'FWSX424+1XG',
            'snFWSX424Plus1XGRouter' => 'FWSX424+1XG',
            'snFWSX424Plus2XGSwitch' => 'FWSX424+2XG',
            'snFWSX424Plus2XGRouter' => 'FWSX424+2XG',
            'snFWSX448Switch' => 'FWSX448',
            'snFWSX448Router' => 'FWSX448',
            'snFWSX448Plus1XGSwitch' => 'FWSX448+1XG',
            'snFWSX448Plus1XGRouter' => 'FWSX448+1XG',
            'snFWSX448Plus2XGSwitch' => 'FWSX448+2XG',
            'snFWSX448Plus2XGRouter' => 'FWSX448+2XG',
            'snFastIronSuperXSwitch' => 'FastIron SuperX Switch',
            'snFastIronSuperXRouter' => 'FastIron SuperX Router',
            'snFastIronSuperXBaseL3Switch' => 'FastIron SuperX Base L3 Switch',
            'snFastIronSuperXPremSwitch' => 'FastIron SuperX Premium Switch',
            'snFastIronSuperXPremRouter' => 'FastIron SuperX Premium Router',
            'snFastIronSuperXPremBaseL3Switch' => 'FastIron SuperX Premium Base L3 Switch',
            'snFastIronSuperX800Switch' => 'FastIron SuperX 800 Switch',
            'snFastIronSuperX800Router' => 'FastIron SuperX 800 Router',
            'snFastIronSuperX800BaseL3Switch' => 'FastIron SuperX 800 Base L3 Switch',
            'snFastIronSuperX800PremSwitch' => 'FastIron SuperX 800 Premium Switch',
            'snFastIronSuperX800PremRouter' => 'FastIron SuperX 800 Premium Router',
            'snFastIronSuperX800PremBaseL3Switch' => 'FastIron SuperX 800 Premium Base L3 Switch',
            'snFastIronSuperX1600Switch' => 'FastIron SuperX 1600 Switch',
            'snFastIronSuperX1600Router' => 'FastIron SuperX 1600 Router',
            'snFastIronSuperX1600BaseL3Switch' => 'FastIron SuperX 1600 Base L3 Switch',
            'snFastIronSuperX1600PremSwitch' => 'FastIron SuperX 1600 Premium Switch',
            'snFastIronSuperX1600PremRouter' => 'FastIron SuperX 1600 Premium Router',
            'snFastIronSuperX1600PremBaseL3Switch' => 'FastIron SuperX 1600 Premium Base L3 Switch',
            'snFastIronSuperXV6Switch' => 'FastIron SuperX V6 Switch',
            'snFastIronSuperXV6Router' => 'FastIron SuperX V6- Ipv4 Router',
            'snFastIronSuperXV6BaseL3Switch' => 'FastIron SuperX V6 Base L3 Switch',
            'snFastIronSuperXV6PremSwitch' => 'FastIron SuperX V6 Premium Switch',
            'snFastIronSuperXV6PremRouter' => 'FastIron SuperX V6 Premium Ipv4 Router',
            'snFastIronSuperXV6PremBaseL3Switch' => 'FastIron SuperX V6 Premium Base L3 Switch',
            'snFastIronSuperXV6Prem6Router' => 'FastIron SuperX V6 Premium Ipv6 Router',
            'snFastIronSuperX800V6Switch' => 'FastIron SuperX 800 V6 Switch',
            'snFastIronSuperX800V6Router' => 'FastIron SuperX 800 V6 - Ipv4 Router',
            'snFastIronSuperX800V6BaseL3Switch' => 'FastIron SuperX 800 V6 Base L3 Switch',
            'snFastIronSuperX800V6PremSwitch' => 'FastIron SuperX 800 Premium V6 Switch',
            'snFastIronSuperX800V6PremRouter' => 'FastIron SuperX 800 Premium V6 - Ipv4 Router',
            'snFastIronSuperX800V6PremBaseL3Switch' => 'FastIron SuperX 800 Premium V6 Base L3 Switch',
            'snFastIronSuperX800V6Prem6Router' => 'FastIron SuperX 800 Premium V6- Ipv6  Router',
            'snFastIronSuperX1600V6Switch' => 'FastIron SuperX 1600 V6 Switch',
            'snFastIronSuperX1600V6Router' => 'FastIron SuperX 1600 V6 - Ipv4 Router',
            'snFastIronSuperX1600V6BaseL3Switch' => 'FastIron SuperX 1600 V6 Base L3 Switch',
            'snFastIronSuperX1600V6PremSwitch' => 'FastIron SuperX 1600 Premium V6 Switch',
            'snFastIronSuperX1600V6PremRouter' => 'FastIron SuperX 1600 Premium V6- Ipv4 Router',
            'snFastIronSuperX1600V6PremBaseL3Switch' => 'FastIron SuperX 1600 Premium V6 Base L3 Switch',
            'snFastIronSuperX1600V6Prem6Router' => 'FastIron SuperX 1600 Premium V6- Ipv6 Router',
            'snBigIronSuperXSwitch' => 'BigIron SuperX Switch',
            'snBigIronSuperXRouter' => 'BigIron SuperX Router',
            'snBigIronSuperXBaseL3Switch' => 'BigIron SuperX Base L3 Switch',
            'snTurboIronSuperXSwitch' => 'TurboIron SuperX Switch',
            'snTurboIronSuperXRouter' => 'TurboIron SuperX Router',
            'snTurboIronSuperXBaseL3Switch' => 'TurboIron SuperX Base L3 Switch',
            'snTurboIronSuperXPremSwitch' => 'TurboIron SuperX Premium Switch',
            'snTurboIronSuperXPremRouter' => 'TurboIron SuperX Premium Router',
            'snTurboIronSuperXPremBaseL3Switch' => 'TurboIron SuperX Premium Base L3 Switch',
            'snNIIMRRouter' => 'NetIron IMR',
            'snBIRX16Switch' => 'BigIron RX16',
            'snBIRX16Router' => 'BigIron RX16',
            'snBIRX8Switch' => 'BigIron RX8',
            'snBIRX8Router' => 'BigIron RX8',
            'snBIRX4Switch' => 'BigIron RX4',
            'snBIRX4Router' => 'BigIron RX4',
            'snBIRX32Switch' => 'BigIron RX32',
            'snBIRX32Router' => 'BigIron RX32',
            'snNIXMR16000Router' => 'NetIron XMR16000',
            'snNIXMR8000Router' => 'NetIron XMR8000',
            'snNIXMR4000Router' => 'NetIron XMR4000',
            'snNIXMR32000Router' => 'NetIron XMR32000',
            'snSecureIronLS100Switch' => 'SecureIronLS 100 Switch',
            'snSecureIronLS100Router' => 'SecureIronLS 100 Router',
            'snSecureIronLS300Switch' => 'SecureIronLS 300 Switch',
            'snSecureIronLS300Router' => 'SecureIronLS 300 Router',
            'snSecureIronTM100Switch' => 'SecureIronTM 100 Switch',
            'snSecureIronTM100Router' => 'SecureIronTM 100 Router',
            'snSecureIronTM300Switch' => 'SecureIronTM 300 Switch',
            'snSecureIronTM300Router' => 'SecureIronTM 300 Router',
            'snNetIronMLX16Router' => 'NetIron MLX-16',
            'snNetIronMLX8Router' => 'NetIron MLX-8',
            'snNetIronMLX4Router' => 'NetIron MLX-4',
            'snNetIronMLX32Router' => 'NetIron MLX-32',
            'snFGS624PSwitch' => 'FGS624P',
            'snFGS624PRouter' => 'FGS624P',
            'snFGS624XGPSwitch' => 'FGS624XGP',
            'snFGS624XGPRouter' => 'FGS624XGP',
            'snFGS624PPOESwitch' => 'FGS624P-POE',
            'snFGS624PPOERouter' => 'FGS624P-POE',
            'snFGS624XGPPOESwitch' => 'FGS624XGP-POE',
            'snFGS624XGPPOERouter' => 'FGS624XGP-POE',
            'snFGS648PSwitch' => 'FGS648P',
            'snFGS648PRouter' => 'FGS648P',
            'snFGS648PPOESwitch' => 'FGS648P-POE',
            'snFGS648PPOERouter' => 'FGS648P-POE',
            'snFLS624Switch' => 'FastIron FLS624',
            'snFLS624Router' => 'FastIron FLS624',
            'snFLS648Switch' => 'FastIron FLS648',
            'snFLS648Router' => 'FastIron FLS648',
            'snSI100Switch' => 'ServerIron SI100',
            'snSI100Router' => 'ServerIron SI100',
            'snSI350Switch' => 'ServerIron 350',
            'snSI350Router' => 'ServerIron 350',
            'snSI450Switch' => 'ServerIron 450',
            'snSI450Router' => 'ServerIron 450',
            'snSI850Switch' => 'ServerIron 850',
            'snSI850Router' => 'ServerIron 850',
            'snSI350PlusSwitch' => 'ServerIron 350 Plus',
            'snSI350PlusRouter' => 'ServerIron 350 Plus',
            'snSI450PlusSwitch' => 'ServerIron 450 Plus',
            'snSI450PlusRouter' => 'ServerIron 450 Plus',
            'snSI850PlusSwitch' => 'ServerIron 850 Plus',
            'snSI850PlusRouter' => 'ServerIron 850 Plus',
            'snServerIronGTcSwitch' => 'ServerIronGT C',
            'snServerIronGTcRouter' => 'ServerIronGT C',
            'snServerIronGTeSwitch' => 'ServerIronGT E',
            'snServerIronGTeRouter' => 'ServerIronGT E',
            'snServerIronGTePlusSwitch' => 'ServerIronGT E Plus',
            'snServerIronGTePlusRouter' => 'ServerIronGT E Plus',
            'snServerIron4GSwitch' => 'ServerIron4G',
            'snServerIron4GRouter' => 'ServerIron4G',
            'wirelessAp' => 'wireless access point',
            'wirelessProbe' => 'wireless probe',
            'ironPointMobility' => 'IronPoint Mobility Series',
            'ironPointMC' => 'IronPoint Mobility Controller',
            'dcrs7504Switch' => 'DCRS-7504',
            'dcrs7504Router' => 'DCRS-7504',
            'dcrs7508Switch' => 'DCRS-7508',
            'dcrs7508Router' => 'DCRS-7508',
            'dcrs7515Switch' => 'DCRS-7515',
            'dcrs7515Router' => 'DCRS-7515',
            'snCes2024F' => 'NetIron CES 2024F',
            'snCes2024C' => 'NetIron CES 2024C',
            'snCes2048F' => 'NetIron CES 2048F',
            'snCes2048C' => 'NetIron CES 2048C',
            'snCes2048FX' => 'NetIron CES 2048F + 2x10G',
            'snCes2048CX' => 'NetIron CES 2048C + 2x10G',
            'snCer2024F' => 'NetIron CER 2024F',
            'snCer2024C' => 'NetIron CER 2024C',
            'snCer2048F' => 'NetIron CER 2048F',
            'snCer2048C' => 'NetIron CER 2048C',
            'snCer2048FX' => 'NetIron CER 2048F + 2x10G',
            'snCer2048CX' => 'NetIron CER 2048C + 2x10G',
            'snTI2X24Router' => 'Stackable TurboIron-X24',
            'snBrocadeMLXe4Router' => 'NetIron MLXe-4',
            'snBrocadeMLXe8Router' => 'NetIron MLXe-8',
            'snBrocadeMLXe16Router' => 'NetIron MLXe-16',
            'snBrocadeMLXe32Router' => 'NetIron MLXe-32',
            'snFastIronStackSwitch' => 'FGS/FLS',
            'snFastIronStackRouter' => 'FGS/FLS',
            'snFastIronStackFCXSwitch' => 'FCX',
            'snFastIronStackFCXBaseL3Router' => 'FCX Base L3',
            'snFastIronStackFCXRouter' => 'FCX Premium Router',
            'snFastIronStackFCXAdvRouter' => 'FCX Advanced Premium Router (BGP)',
            'snFastIronStackICX6610Switch' => 'FastIron ICX 6610 stack',
            'snFastIronStackICX6610BaseL3Router' => 'FastIron ICX 6610 stack Base L3',
            'snFastIronStackICX6610Router' => 'FastIron ICX 6610 stack Base Router',
            'snFastIronStackICX6610PRouter' => 'FastIron ICX 6610 stack Premium Router',
            'snFastIronStackICX6610ARouter' => 'FastIron ICX 6610 stack Advanced Router',
            'snFastIronStackICX6430Switch' => 'FastIron ICX 6430 stack',
            'snFastIronStackICX6450Switch' => 'FastIron ICX 6450 stack',
            'snFastIronStackICX6450BaseL3Router' => 'FastIron ICX 6450 stack Base L3',
            'snFastIronStackICX6450Router' => 'FastIron ICX 6450 stack Router',
            'snFastIronStackICX6450PRouter' => 'FastIron ICX 6450 stack Premium Router',
            'snFastIronStackMixedStackSwitch' => 'FastIron MixedStack',
            'snFastIronStackMixedStackBaseL3Router' => 'FastIron MixedStack Base L3',
            'snFastIronStackMixedStackRouter' => 'FastIron MixedStack Router',
            'snFastIronStackMixedStackPRouter' => 'FastIron MixedStack Premium Router',
            'snFastIronStackMixedStackARouter' => 'FastIron MixedStack Advanced Router',
            'snFastIronStackICX7750Switch' => 'FastIron ICX 7750 stack',
            'snFastIronStackICX7750BaseL3Router' => 'FastIron ICX 7750 stack Base L3',
            'snFastIronStackICX7750Router' => 'FastIron ICX 7750 stack Router',
            'snFastIronStackICX7450Switch' => 'FastIron ICX 7450 stack',
            'snFastIronStackICX7450BaseL3Router' => 'FastIron ICX 7450 stack Base L3',
            'snFastIronStackICX7450Router' => 'FastIron ICX 7450 stack Router',
            'snFastIronStackICX7250Switch' => 'FastIron ICX 7250 stack',
            'snFastIronStackICX7250BaseL3Router' => 'FastIron ICX 7250 stack Base L3',
            'snFastIronStackICX7250Router' => 'FastIron ICX 7250 stack Router',
            'snFLSLC624Switch' => 'FLSLC624',
            'snFLSLC624Router' => 'FLSLC624',
            'snFLSLC624POESwitch' => 'FLSLC624-POE',
            'snFLSLC624POERouter' => 'FLSLC624-POE',
            'snFLSLC648Switch' => 'FLSLC648',
            'snFLSLC648Router' => 'FLSLC648',
            'snFLSLC648POESwitch' => 'FLSLC648-POE',
            'snFLSLC648POERouter' => 'FLSLC648-POE',
            'snFWS624Switch' => 'FWS624',
            'snFWS624BaseL3Router' => 'FWS624 Base L3',
            'snFWS624EdgePremRouter' => 'FWS624 Edge Prem',
            'snFWS624GSwitch' => 'FWS624G',
            'snFWS624GBaseL3Router' => 'FWS624G Base L3',
            'snFWS624GEdgePremRouter' => 'FWS624G Edge Prem',
            'snFWS624POESwitch' => 'FWS624-POE',
            'snFWS624POEBaseL3Router' => 'FWS624-POE Base L3',
            'snFWS624POEEdgePremRouter' => 'FWS624-POE Edge Prem',
            'snFWS624GPOESwitch' => 'FWS624G-POE',
            'snFWS624GPOEBaseL3Router' => 'FWS624G-POE Base L3',
            'snFWS624GPOEEdgePremRouter' => 'FWS624G-POE Edge Prem',
            'snFWS648Switch' => 'FWS648',
            'snFWS648BaseL3Router' => 'FWS648 Base L3',
            'snFWS648EdgePremRouter' => 'FWS648 Edge Prem',
            'snFWS648GSwitch' => 'FWS648G',
            'snFWS648GBaseL3Router' => 'FWS648G Base L3',
            'snFWS648GEdgePremRouter' => 'FWS648G Edge Prem',
            'snFWS648POESwitch' => 'FWS648-POE',
            'snFWS648POEBaseL3Router' => 'FWS648-POE Base L3',
            'snFWS648POEEdgePremRouter' => 'FWS648-POE Edge Prem',
            'snFWS648GPOESwitch' => 'FWS648G-POE',
            'snFWS648GPOEBaseL3Router' => 'FWS648G-POE Base L3',
            'snFWS648GPOEEdgePremRouter' => 'FWS648G-POE Edge Prem',
            'snFCX624SSwitch' => 'FCX624S',
            'snFCX624SBaseL3Router' => 'FCX624S Base L3',
            'snFCX624SRouter' => 'FCX624S Premium Router',
            'snFCX624SAdvRouter' => 'FCX624S Advanced Premium Router (BGP)',
            'snFCX624SHPOESwitch' => 'FCX624S PoE+',
            'snFCX624SHPOEBaseL3Router' => 'FCX624S PoE+ Base L3',
            'snFCX624SHPOERouter' => 'FCX624S PoE+ Premium Router',
            'snFCX624SHPOEAdvRouter' => 'FCX624S PoE+ Advanced Premium Router (BGP)',
            'snFCX624SFSwitch' => 'FCX624SF',
            'snFCX624SFBaseL3Router' => 'FCX624SF Base L3',
            'snFCX624SFRouter' => 'FCX624SF Premium Router',
            'snFCX624SFAdvRouter' => 'FCX624SF Advanced Premium Router (BGP)',
            'snFCX624Switch' => 'FCX624',
            'snFCX624BaseL3Router' => 'FCX624 Base L3',
            'snFCX624Router' => 'FCX624 Premium Router',
            'snFCX624AdvRouter' => 'FCX624 Advanced Premium Router (BGP)',
            'snFCX648SSwitch' => 'FCX648S',
            'snFCX648SBaseL3Router' => 'FCX648S Base L3',
            'snFCX648SRouter' => 'FCX648S Premium Router',
            'snFCX648SAdvRouter' => 'FCX648S Advanced Premium Router (BGP)',
            'snFCX648SHPOESwitch' => 'FCX648S PoE+',
            'snFCX648SHPOEBaseL3Router' => 'FCX648S PoE+ Base L3',
            'snFCX648SHPOERouter' => 'FCX648S PoE+ Premium Router',
            'snFCX648SHPOEAdvRouter' => 'FCX648S PoE+ Advanced Premium Router (BGP)',
            'snFCX648Switch' => 'FCX648',
            'snFCX648BaseL3Router' => 'FCX648 Base L3',
            'snFCX648Router' => 'FCX648 Premium Router',
            'snFCX648AdvRouter' => 'FCX648 Advanced Premium Router (BGP)',
            'snICX661024Switch' => 'FastIron ICX 6610 24-port Switch',
            'snICX661024BaseL3Router' => 'FastIron ICX 6610 24-port Base L3',
            'snICX661024Router' => 'FastIron ICX 6610 24-port Base Router',
            'snICX661024PRouter' => 'FastIron ICX 6610 24-port Premium Router',
            'snICX661024ARouter' => 'FastIron ICX 6610 24-port Advanced Router',
            'snICX661024HPOESwitch' => 'FastIron ICX 6610 24-port PoE+',
            'snICX661024HPOEBaseL3Router' => 'FastIron ICX 6610 24-port PoE+ Base L3',
            'snICX661024HPOERouter' => 'FastIron ICX 6610 24-port PoE+ Base Router',
            'snICX661024HPOEPRouter' => 'FastIron ICX 6610 24-port PoE+ Premium Router',
            'snICX661024HPOEARouter' => 'FastIron ICX 6610 24-port PoE+ Advanced Router',
            'snICX661024FSwitch' => 'FastIron ICX 6610 24F Switch',
            'snICX661024FBaseL3Router' => 'FastIron ICX 6610 24F Base L3',
            'snICX661024FRouter' => 'FastIron ICX 6610 24F Base Router',
            'snICX661024FPRouter' => 'FastIron ICX 6610 24F Premium Router',
            'snICX661024FARouter' => 'FastIron ICX 6610 24F Advanced Router',
            'snICX661048Switch' => 'FastIron ICX 6610 48-port Switch',
            'snICX661048BaseL3Router' => 'FastIron ICX 6610 48-port Base L3',
            'snICX661048Router' => 'FastIron ICX 6610 48-port Base Router',
            'snICX661048PRouter' => 'FastIron ICX 6610 48-port Premium Router',
            'snICX661048ARouter' => 'FastIron ICX 6610 48-port Advanced Router',
            'snICX661048HPOESwitch' => 'FastIron ICX 6610 48-port PoE+ Switch',
            'snICX661048HPOEBaseL3Router' => 'FastIron ICX 6610 48-port PoE+ Base L3',
            'snICX661048HPOERouter' => 'FastIron ICX 6610 48-port PoE+ Base Router',
            'snICX661048HPOEPRouter' => 'FastIron ICX 6610 48-port PoE+ Premium Router',
            'snICX661048HPOEARouter' => 'FastIron ICX 6610 48-port PoE+ Advanced Router',
            'snICX643024Switch' => 'FastIron ICX 6430 24-port Switch',
            'snICX643024HPOESwitch' => 'FastIron ICX 6430 24-port PoE+',
            'snICX643048Switch' => 'FastIron ICX 6430 48-port',
            'snICX643048HPOESwitch' => 'FastIron ICX 6430 48-port PoE+',
            'snICX6430C12Switch' => 'FastIron ICX 6430 C12 Switch',
            'snICX645024Switch' => 'FastIron ICX 6450 24-port Switch',
            'snICX645024BaseL3Router' => 'FastIron ICX 6450 24-port Base L3',
            'snICX645024Router' => 'FastIron ICX 6450 24-port Base Router',
            'snICX645024PRouter' => 'FastIron ICX 6450 24-port Premium Router',
            'snICX645024HPOESwitch' => 'FastIron ICX 6450 24-port PoE+ Switch',
            'snICX645024HPOEBaseL3Router' => 'FastIron ICX 6450 24-port PoE+ Base L3',
            'snICX645024HPOERouter' => 'FastIron ICX 6450 24-port PoE+ Base Router',
            'snICX645024HPOEPRouter' => 'FastIron ICX 6450 24-port PoE+ Premium Router',
            'snICX645048Switch' => 'FastIron ICX 6450 48-port Switch',
            'snICX645048BaseL3Router' => 'FastIron ICX 6450 48-port Base L3',
            'snICX645048Router' => 'FastIron ICX 6450 48-port Base Router',
            'snICX645048PRouter' => 'FastIron ICX 6450 48-port Premium Router',
            'snICX645048HPOESwitch' => 'FastIron ICX 6450 48-port PoE+ Switch',
            'snICX645048HPOEBaseL3Router' => 'FastIron ICX 6450 48-port PoE+ Base L3',
            'snICX645048HPOERouter' => 'FastIron ICX 6450 48-port PoE+ Base Router',
            'snICX645048HPOEPRouter' => 'FastIron ICX 6450 48-port PoE+ Premium Router',
            'snICX6450C12PDSwitch' => 'FastIron ICX 6450 C12-PD Switch',
            'snICX6450C12PDBaseL3Router' => 'FastIron ICX 6450 C12-PD Base L3',
            'snICX6450C12PDRouter' => 'FastIron ICX 6450 C12-PD Base',
            'snICX6450C12PDPRouter' => 'FastIron ICX 6450 C12-PD Premium',
            'snICX665064Switch' => 'FastIron ICX 6650 64-port Switch',
            'snICX665064BaseL3Router' => 'FastIron ICX 6650 64-port Base L3',
            'snICX665064Router' => 'FastIron ICX 6650 64-port Router',
            'snICX775048CSwitch' => 'FastIron ICX 7750 48-port Switch',
            'snICX775048CBaseL3Router' => 'FastIron ICX 7750 48-port Base L3',
            'snICX775048CRouter' => 'FastIron ICX 7750 48-port Router',
            'snICX775048FSwitch' => 'FastIron ICX 7750 48-port Switch',
            'snICX775048FBaseL3Router' => 'FastIron ICX 7750 48-port Base L3',
            'snICX775048FRouter' => 'FastIron ICX 7750 48-port Router',
            'snICX775026QSwitch' => 'FastIron ICX 7750 26-port Switch',
            'snICX775026QBaseL3Router' => 'FastIron ICX 7750 26-port Base L3',
            'snICX775026QRouter' => 'FastIron ICX 7750 26-port Router',
            'snICX745024Switch' => 'FastIron ICX 7450 24-port',
            'snICX745024BaseL3Router' => 'FastIron ICX 7450 24-port Base L3',
            'snICX745024Router' => 'FastIron ICX 7450 24-port Router',
            'snICX745024HPOESwitch' => 'FastIron ICX 7450 24-port PoE+',
            'snICX745024HPOEBaseL3Router' => 'FastIron ICX 7450 24-port PoE+ Base L3',
            'snICX745024HPOERouter' => 'FastIron ICX 7450 24-port PoE+ Base Router',
            'snICX745048Switch' => 'FastIron ICX 7450 48-port Switch',
            'snICX745048BaseL3Router' => 'FastIron ICX 7450 48-port Base L3',
            'snICX745048Router' => 'FastIron ICX 7450 48-port Router',
            'snICX745048HPOESwitch' => 'FastIron ICX 7450 PoE+ 48-port Switch',
            'snICX745048HPOEBaseL3Router' => 'FastIron ICX 7450 PoE+ 48-port Base L3',
            'snICX745048HPOERouter' => 'FastIron ICX 7450 PoE+ 48-port Router',
            'snICX745048FSwitch' => 'FastIron ICX 7450 48-port Switch',
            'snICX745048FBaseL3Router' => 'FastIron ICX 7450 48-port Base L3',
            'snICX745048FRouter' => 'FastIron ICX 7450 48-port Router',
            'snICX725024Switch' => 'FastIron ICX 7250 24',
            'snICX725024BaseL3Router' => 'FastIron ICX 7250 24 Base L3',
            'snICX725024Router' => 'FastIron ICX 7250 24 Router',
            'snICX725024HPOESwitch' => 'FastIron ICX 7250 24 PoE+',
            'snICX725024HPOEBaseL3Router' => 'FastIron ICX 7250 24 PoE+ Base L3',
            'snICX725024HPOERouter' => 'FastIron ICX 7250 24 PoE+ Base Router',
            'snICX725024GSwitch' => 'FastIron ICX 7250 24G',
            'snICX725024GBaseL3Router' => 'FastIron ICX 7250 24G Base L3',
            'snICX725024GRouter' => 'FastIron ICX 7250 24G Router',
            'snICX725048Switch' => 'FastIron ICX 7250 48-port Switch',
            'snICX725048BaseL3Router' => 'FastIron ICX 7250 48-port Base L3',
            'snICX725048Router' => 'FastIron ICX 7250 48-port Router',
            'snICX725048HPOESwitch' => 'FastIron ICX 7250 48-port PoE+ Switch',
            'snICX725048HPOEBaseL3Router' => 'FastIron ICX 7250 48-port PoE+ Base L3',
            'snICX725048HPOERouter' => 'FastIron ICX 7250 48-port PoE+ Router',
        ];

        $this->getDevice()->hardware = array_str_replace($rewrite_ironware_hardware, $this->getDevice()->hardware);
    }
}
