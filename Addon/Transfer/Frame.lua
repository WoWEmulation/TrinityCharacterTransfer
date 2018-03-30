content = "";
loaded = false;

SLASH_TRANSFER1 = '/transfer';
function SlashCmdList.TRANSFER(msg, editbox)
    if (EditBox1:IsVisible()) then
        HideUIPanel(EditBox1);
    else
        ShowUIPanel(EditBox1);
    end
end

function OnLoad()
    LoadObsah();
    EditBox1:SetText(content);
    loaded = true;
end

function EditBox1_OnTextChanged()
    if (loaded == false) then
        OnLoad();
    end
end

function LoadObsah()
    loadBags();
    content = content .. "|";
    loadEquip();
    content = content .. "|";
    content = content .. GetMoney();
    content = content .. "|";
    content = content .. UnitLevel("player");
    content = content .. "|";
    content = content .. UnitName("player");
    local playerClass = UnitClass("player");
    content = content .. "|";
    content = content .. playerClass;
end

function loadEquip()
    local buffer = "";
    local i;
    for i = 1, 24 do

        local count = GetInventoryItemCount("player", i);
        local id = GetInventoryItemID("player", i);

        if (id ~= nil) then
            buffer = buffer .. i .. "," .. id .. ";";
        end
    end
    content = content .. buffer;
end

function loadBags()
    content = content .. BagString(0);
    content = content .. BagString(1);
    content = content .. BagString(2);
    content = content .. BagString(3);
    content = content .. BagString(4);
end

function BagString(b)
    local buf = "";
    local sn = GetContainerNumSlots(b);
    for si = 1, sn do
        buf = buf .. BagSlotString(b, si);
    end
    return buf;
end

function BagSlotString(b, s)
    local buffer = "";
    local l = GetContainerItemLink(b, s);
    if (l ~= nill) then
        local _, ic = GetContainerItemInfo(b, s);
        local id = GetContainerItemID(b, s);
        buffer = buffer .. ic .. "," .. id .. ";";
    end;
    return buffer;
end 

