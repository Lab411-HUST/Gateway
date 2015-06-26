/********************************************************************************
 * Tên dự án        : Emboard
 * Nhóm thực hiện   : Sigate
 * Phòng nghiên cứu : Hệ nhúng nối mạng
 * Trường           : Đại Học Bách Khoa Hà Nội
 * Mô tả chung      : 1. Chương trình thu thập dữ liệu nhiệt độ, độ ẩm từ các sensor 
 *                    2. Ra quyết định điều khiển đến các actor phục vụ chăm sóc lan và cảnh báo cháy rừng
 *                    3. Chuyển tiếp dữ liệu về Web server để quản lý và theo dõi qua internet
 * IDE              : Microsoft Visual Studio 2008
 * Target Platform  : Window CE Device
 * *****************************************************************************/

using System;
using System.Collections.Generic;
using System.Text;
using System.IO.Ports;
using System.IO;
using System.Windows.Forms;
using System.Threading;
namespace Emboard
{
    class COM:ShowData
    {
        /// <summary>
        /// Khai bao cong COM cho truyen nhan du lieu tu Router Emboard
        /// </summary>
        public SerialPort COMPort = new SerialPort();

        /// <summary>
        /// Cong COM truyen nhan du lieu xuong module SMS
        /// </summary>
        protected SerialPort COMSMS = new SerialPort();

        /// <summary>
        /// Thread doc du lieu tu cong COM
        /// </summary>
        public Thread comPort = null;

        /// <summary>
        /// Du lieu nhan ve tu module SMS qua cong COM
        /// </summary>
        private static string dataReadCOMSMS = null;
        public static string DataReadCOMSMS
        {
            set { dataReadCOMSMS = value; }
            get { return dataReadCOMSMS; }
        }

        /// <summary>
        /// Du lieu doc ve tu Router Emboard thong qua COM
        /// </summary>
        private string dataReadCOM = null;
        public string DataReadCOM
        {
            set { dataReadCOM = value; }
            get { return dataReadCOM; }
        }

        /// <summary>
        /// Loi tra ve trong bat loi
        /// </summary>
        protected string ERR; 

        /// <summary>
        /// Ham khoi tao cong COM truyen nhan xuong router emboard
        /// </summary>
        /// <param name="port"></param>
        /// <param name="baud"></param>
        public COM()
        {
            COMPort.PortName = "COM2";
            COMPort.BaudRate = 19200;
            COMPort.StopBits = StopBits.One;
            COMPort.Parity = Parity.None;
            COMPort.DataBits = 8;
            COMPort.ReceivedBytesThreshold = 1;
        }

        public void ThreadComPort()
        {
            comPort = new Thread(new ThreadStart(openComPort));
            comPort.Start();
        }
        /// <summary>
        /// Ham nhan du lieu tu cong COM
        /// Du lieu gui tu cac : sensor, actor
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        public virtual void comPort_DataReceived(object sender, SerialDataReceivedEventArgs e)
        {}

        /// <summary>
        /// Ham mo cong COM
        /// </summary>
        /// <returns></returns>
        public void openComPort()
        {
            try
            {
                if (COMPort.IsOpen == false)
                {
                    COMPort.Open();
                    DisplayData("(" + showTime() + ")Da mo cong COM", txtShowData);
                }
                COMPort.DataReceived += new SerialDataReceivedEventHandler(comPort_DataReceived);
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
                DisplayData("Dang ket noi.......", txtShowData);
            }
        }

        /// <summary>
        /// Ham dong cong COM
        /// </summary>
        /// <returns></returns>
        public int closeCOM()
        {
            try
            {
                if (COMPort.IsOpen == true)
                    COMPort.Close();
                DisplayData("(" + showTime() + ")Da dong cong COM", txtShowData);
                return 1;
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
                return -1;
            }
        }

        /// <summary>
        /// Ham gui du lieu xuong cong COM
        /// Gui lenh qua cong COM xuong Router Emboard
        /// </summary>
        /// <param name="com"></param>
        /// <returns></returns>
        public int writeByteData(byte[] com)
        {
            try
            {
                if (COMPort.IsOpen == true)
                {
                    COMPort.Write(com, 0, com.Length);
                }
                return 1;
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
                return -1;
            }
        }

        /// <summary>
        /// Cac ham phuc vu truyen nhan du lieu qua cong COM module SMS
        /// </summary>
        public void COMSMSInit()
        {
            COMSMS.PortName = "COM4";
            COMSMS.BaudRate = 115200;
            COMSMS.Parity = Parity.None;
            COMSMS.StopBits = StopBits.One;
            COMSMS.DataBits = 8;
            COMSMS.ReceivedBytesThreshold = 1;
            COMSMS.DataReceived += new SerialDataReceivedEventHandler(comSMS_DataReceived);
        }

        
        /// <summary>
        /// Nhan du lieu tu module GSM qu cong COM
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        public void comSMS_DataReceived(object sender, SerialDataReceivedEventArgs e)
        {
            try
            {
                if (COMSMS.IsOpen == true)
                {
                    //dataReadCOM = COMSMS.ReadLine();
                    //dataReadCOMSMS = COMSMS.ReadExisting();
                }
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
            }
        }

        /// <summary>
        /// Chuyen doi string sang mang byte
        /// </summary>
        /// <param name="com"></param>
        /// <returns></returns>
        public byte[] ConvertTobyte(string com)
        {
            byte[] command = new byte[4];
            string nn1 = com.Substring(0, 2);
            string nn2 = com.Substring(2, 2);
            string ss = com.Substring(4, 2);
            int kytu = Convert.ToInt16(com[7]);
            int byte0 = int.Parse(nn1, System.Globalization.NumberStyles.HexNumber);
            int byte1 = int.Parse(nn2, System.Globalization.NumberStyles.HexNumber);
            int byte3 = int.Parse(ss, System.Globalization.NumberStyles.Integer);
            int kq = 0;
            if (com[6] == '0')
            {
                kq = byte3;
            }
            if (com[6] == '1')
            {
                kq = byte3 + 128;
            }
            command[0] = (byte)byte0;
            command[1] = (byte)byte1;
            command[2] = (byte)kq;
            command[3] = (byte)kytu;
            return command;
        }

        /// <summary>
        /// Dong cong COM gui tin nhan
        /// </summary>
        public void closeCOMSMS()
        {
            try
            {
                if (COMSMS.IsOpen == true)
                    COMSMS.Close();
            }
            catch (Exception ex)
            {
                ERR = ex.Message;
            }
        }
    }
}
